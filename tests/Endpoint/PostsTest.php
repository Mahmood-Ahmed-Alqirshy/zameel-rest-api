<?php

use App\Models\College;
use App\Models\File;
use App\Models\Group;
use App\Models\Major;
use App\Models\Post;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;

it('can add public post as admin', function () {
    $data = [
        'content' => 'hi',
    ];
    $token = TestCase::$adminToken;
    postJson('/api/posts', $data, ['Authorization' => 'Bearer '.$token])
        ->assertCreated();
});

it('can add post to college and major', function () {
    $college = College::create(['name' => 'aaa']);
    $major = Major::create(['name' => 'aaa', 'years' => 4, 'college_id' => $college->id, 'degree_id' => 1]);

    User::find(User::MANAGER)->colleges()->attach($college->id);

    $dataForCollege = [
        'taggable_type' => 'App\Models\College',
        'taggable_id' => $college->id,
        'content' => 'hi',
    ];

    $dataForMajor = [
        'taggable_type' => 'App\Models\Major',
        'taggable_id' => $major->id,
        'content' => 'hi',
    ];

    postJson('/api/posts', $dataForCollege, ['Authorization' => 'Bearer '.TestCase::$managerToken])
        ->assertCreated();

    postJson('/api/posts', $dataForMajor, ['Authorization' => 'Bearer '.TestCase::$managerToken])
        ->assertCreated();
});

it('can add post to group', function () {
    $group = Group::factory()->create();
    Group::find($group->id)->members()->attach(User::REPRESENTER, ['is_representer' => true]);
    $subject = Subject::create(['name' => 'aaa']);
    User::find(User::ACADEMIC)->teachingGroups()->attach($group->id, ['subject_id' => $subject->id]);
    User::find(User::MANAGER)->teachingGroups()->attach($group->id, ['subject_id' => $subject->id]);

    $data = [
        'taggable_type' => 'App\Models\Group',
        'taggable_id' => $group->id,
        'content' => 'hi',
    ];

    $dataForTeachers = [
        'taggable_type' => 'App\Models\Group',
        'taggable_id' => $group->id,
        'content' => 'hi',
        'subject_id' => $subject->id,
    ];

    postJson('/api/posts', $data, ['Authorization' => 'Bearer '.TestCase::$representerToken])
        ->assertCreated();
    postJson('/api/posts', $dataForTeachers, ['Authorization' => 'Bearer '.TestCase::$managerToken])
        ->assertCreated();
    postJson('/api/posts', $dataForTeachers, ['Authorization' => 'Bearer '.TestCase::$academicToken])
        ->assertCreated();
});

it('can\'t add post to unexisted group', function () {
    $data = [
        'taggable_type' => 'App\\Models\\Group',
        'taggable_id' => 9999,
        'content' => 'hi',
    ];
    postJson('/api/posts', $data, ['Authorization' => 'Bearer '.TestCase::$adminToken])
        ->assertUnprocessable();
});

it('can add file or images with post', function () {
    $dataFile = [
        'content' => 'hi',
        'attachment' => [
            'type' => 'file',
            'file' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
        ],
    ];
    $dataImages = [
        'content' => 'hi',
        'attachment' => [
            'type' => 'images',
            'images' => [
                UploadedFile::fake()->image('a.png', 1024, 100),
                UploadedFile::fake()->image('b.jpeg', 1024, 111),
                UploadedFile::fake()->image('c.webp', 1024, 333),
            ],
        ],
    ];
    $token = TestCase::$adminToken;
    $fileResponse = postJson('/api/posts', $dataFile, ['Authorization' => 'Bearer '.$token])
        ->assertCreated()->json();

    $imagesResponse = postJson('/api/posts', $dataImages, ['Authorization' => 'Bearer '.$token])
        ->assertCreated()->json();

    expect(Post::find($fileResponse['data']['id'])->files()->count())->toBe(1);
    expect(Post::find($imagesResponse['data']['id'])->files()->count())->toBe(3);

});

it('can delete post with file or images', function () {
    $dataFile = [
        'content' => 'hi',
        'attachment' => [
            'type' => 'file',
            'file' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
        ],
    ];
    $dataImages = [
        'content' => 'hi',
        'attachment' => [
            'type' => 'images',
            'images' => [
                UploadedFile::fake()->image('a.png', 1024, 100),
                UploadedFile::fake()->image('b.jpeg', 1024, 111),
                UploadedFile::fake()->image('c.webp', 1024, 333),
            ],
        ],
    ];
    $token = TestCase::$adminToken;
    $fileResponse = postJson('/api/posts', $dataFile, ['Authorization' => 'Bearer '.$token])
        ->assertCreated()->json();

    $imagesResponse = postJson('/api/posts', $dataImages, ['Authorization' => 'Bearer '.$token])
        ->assertCreated()->json();

    expect(Post::find($fileResponse['data']['id'])->files()->count())->toBe(1);
    expect(Post::find($imagesResponse['data']['id'])->files()->count())->toBe(3);

    deleteJson('/api/posts/'.$fileResponse['data']['id'], [], ['Authorization' => 'Bearer '.$token])
        ->assertOK();

    deleteJson('/api/posts/'.$imagesResponse['data']['id'], [], ['Authorization' => 'Bearer '.$token])
        ->assertOk();

    expect(File::where('post_id', $fileResponse['data']['id'])->count())->toBe(0);
    expect(File::where('post_id', $imagesResponse['data']['id'])->count())->toBe(0);

});
