<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortnerTest extends TestCase
{
    use RefreshDatabase;

    protected Company $companyA;
    protected Company $companyB;
    protected User $superAdmin;
    protected User $adminA;
    protected User $memberA;
    protected User $adminB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyA = Company::factory()->create(['name' => 'Company A']);
        $this->companyB = Company::factory()->create(['name' => 'Company B']);

        $this->superAdmin = User::factory()->create(['role' => 'super-admin']);

        $this->adminA = User::factory()->create([
            'role' => 'admin',
            'company_id' => $this->companyA->id
        ]);

        $this->memberA = User::factory()->create([
            'role' => 'member',
            'company_id' => $this->companyA->id
        ]);

        $this->adminB = User::factory()->create([
            'role' => 'admin',
            'company_id' => $this->companyB->id
        ]);
    }

    /**
     * Admin and Member can create short urls
     */
    public function test_admin_and_member_can_create_short_urls()
    {
        // Test Admin Creation
        $responseAdmin = $this->actingAs($this->adminA)
                              ->post(route('urls.store'), [
                                  'url' => 'https://laravel.com'
                              ]);

        $responseAdmin->assertRedirect();
        $this->assertDatabaseHas('urls', [
            'user_id' => $this->adminA->id,
            'url' => 'https://laravel.com'
        ]);

        //Test Member Creation
        $responseMember = $this->actingAs($this->memberA)
                               ->post(route('urls.store'), [
                                   'url' => 'https://github.com'
                               ]);

        $responseMember->assertRedirect();
        $this->assertDatabaseHas('urls', [
            'user_id' => $this->memberA->id,
            'url' => 'https://github.com'
        ]);
    }

    /**
     * SuperAdmin cannot create short urls and will return 403
     */
    public function test_super_admin_cannot_create_short_urls()
    {
        $response = $this->actingAs($this->superAdmin)
                         ->post(route('urls.store'), [
                             'url' => 'https://laravel.com'
                         ]);

        $response->assertStatus(403);
        $this->assertDatabaseEmpty('urls');
    }

    /**
     * Admin can only see the list of all short urls created in their own company
     */
    public function test_admin_can_only_see_urls_created_in_their_own_company()
    {
        $urlAdminA = Url::factory()->create(['user_id' => $this->adminA->id]);
        $urlMemberA = Url::factory()->create(['user_id' => $this->memberA->id]);
        $urlAdminB = Url::factory()->create(['user_id' => $this->adminB->id]);

        $response = $this->actingAs($this->adminA)->get(route('urls.index'));

        $response->assertStatus(200);

        // Assert they see URLs from their own company (Company A)
        $response->assertSee($urlAdminA->url);
        $response->assertSee($urlMemberA->url);

        // Assert they DO NOT see URLs from the other company (Company B)
        $response->assertDontSee($urlAdminB->url);
    }

    /**
     * Requirement 4: Member can only see the list of all short urls created by themselves
     */
    public function test_member_can_only_see_urls_created_by_themselves()
    {
        $myUrl = Url::factory()->create(['user_id' => $this->memberA->id]);
        $adminUrl = Url::factory()->create(['user_id' => $this->adminA->id]);

        $response = $this->actingAs($this->memberA)->get(route('urls.index'));

        $response->assertStatus(200);

        // Assert they see their own URL
        $response->assertSee($myUrl->url);

        // Assert they DO NOT see the Admin's URL (even though they share a company)
        $response->assertDontSee($adminUrl->url);
    }

    /**
     *  Short urls are publicly resolvable and redirect to the original url
     */
    public function test_short_urls_are_publicly_resolvable_and_redirect_to_original_url()
    {
        Url::factory()->create([
            'user_id' => $this->memberA->id,
            'url' => 'https://sembark.com/travel-software/add-on/notify/',
            'url_code' => 'aBcDeF'
        ]);

        // Attempt to hit the public resolver route as a guest (unauthenticated)
        $response = $this->get('/aBcDeF');

        // Assert it performs an external redirect to the correct original URL
        $response->assertRedirect('https://sembark.com/travel-software/add-on/notify/');
    }
}
