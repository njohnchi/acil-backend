<?php

use App\Models\User;
use App\Models\YeastRegistration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    Storage::fake('public');
    Role::firstOrCreate(['name' => 'admin']);

    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
});

test('guests cannot access yeast registrations index', function () {
    $response = get(route('yeast-registrations.index'));

    $response->assertRedirect(route('login'));
});

test('non-admin users cannot access yeast registrations index', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = get(route('yeast-registrations.index'));

    $response->assertForbidden();
});

test('admin can view yeast registrations index', function () {
    actingAs($this->admin);

    $response = get(route('yeast-registrations.index'));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page->component('YeastRegistrations/Index'));
});

test('yeast registrations index displays paginated data', function () {
    actingAs($this->admin);

    YeastRegistration::factory()->count(25)->create();

    $response = get(route('yeast-registrations.index'));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('YeastRegistrations/Index')
        ->has('registrations.data', 20));
});

test('admin can view a single yeast registration', function () {
    actingAs($this->admin);

    $registration = YeastRegistration::factory()->create([
        'surname' => 'Test',
        'first_name' => 'User',
        'email' => 'test@example.com',
    ]);

    $response = get(route('yeast-registrations.show', $registration));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('YeastRegistrations/Show')
        ->where('registration.personal_information.surname', 'Test')
        ->where('registration.personal_information.email', 'test@example.com'));
});

test('admin can export yeast registrations to excel', function () {
    actingAs($this->admin);

    YeastRegistration::factory()->count(5)->create();

    $response = get(route('yeast-registrations.export'));

    $response->assertSuccessful();
    $response->assertDownload();
    $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

test('admin can download identification document', function () {
    actingAs($this->admin);

    $file = UploadedFile::fake()->create('identification.pdf', 100, 'application/pdf');
    $path = $file->store('registrations/identifications', 'public');

    $registration = YeastRegistration::factory()->create([
        'identification_document_path' => $path,
    ]);

    $response = get(route('yeast-registrations.download', [
        'yeastRegistration' => $registration,
        'documentType' => 'identification',
    ]));

    $response->assertSuccessful();
    $response->assertDownload();
});

test('admin can download certificates', function () {
    actingAs($this->admin);

    $file = UploadedFile::fake()->create('certificates.pdf', 100, 'application/pdf');
    $path = $file->store('registrations/certificates', 'public');

    $registration = YeastRegistration::factory()->create([
        'certificates_path' => $path,
    ]);

    $response = get(route('yeast-registrations.download', [
        'yeastRegistration' => $registration,
        'documentType' => 'certificates',
    ]));

    $response->assertSuccessful();
    $response->assertDownload();
});

test('admin can download passport photograph', function () {
    actingAs($this->admin);

    $file = UploadedFile::fake()->image('passport.jpg');
    $path = $file->store('registrations/photographs', 'public');

    $registration = YeastRegistration::factory()->create([
        'passport_photograph_path' => $path,
    ]);

    $response = get(route('yeast-registrations.download', [
        'yeastRegistration' => $registration,
        'documentType' => 'passport',
    ]));

    $response->assertSuccessful();
    $response->assertDownload();
});

test('admin can download cv', function () {
    actingAs($this->admin);

    $file = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');
    $path = $file->store('registrations/cvs', 'public');

    $registration = YeastRegistration::factory()->create([
        'cv_path' => $path,
    ]);

    $response = get(route('yeast-registrations.download', [
        'yeastRegistration' => $registration,
        'documentType' => 'cv',
    ]));

    $response->assertSuccessful();
    $response->assertDownload();
});

test('admin can download supporting documents', function () {
    actingAs($this->admin);

    $file = UploadedFile::fake()->create('supporting.pdf', 100, 'application/pdf');
    $path = $file->store('registrations/supporting-documents', 'public');

    $registration = YeastRegistration::factory()->create([
        'supporting_documents_path' => $path,
    ]);

    $response = get(route('yeast-registrations.download', [
        'yeastRegistration' => $registration,
        'documentType' => 'supporting',
    ]));

    $response->assertSuccessful();
    $response->assertDownload();
});

test('returns error when downloading non-existent document', function () {
    actingAs($this->admin);

    $registration = YeastRegistration::factory()->create([
        'cv_path' => null,
    ]);

    $response = get(route('yeast-registrations.download', [
        'yeastRegistration' => $registration,
        'documentType' => 'cv',
    ]));

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Document not found');
});

test('returns error when downloading with invalid document type', function () {
    actingAs($this->admin);

    $registration = YeastRegistration::factory()->create();

    $response = get(route('yeast-registrations.download', [
        'yeastRegistration' => $registration,
        'documentType' => 'invalid',
    ]));

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Document not found');
});
