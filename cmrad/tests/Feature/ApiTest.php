<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User as Respository;

class ApiTest extends TestCase
{
    /**
     * Test: should return all respositories
     */
    public function testGetRepositories()
    {
        //Create fake repository
        $repository = factory(Respository::class)->create();
        $tokenResult = $repository->createToken('Personal Access Token');

        //Call
        $this->withHeaders(['Authorization' => 'Bearer '.$tokenResult->accessToken])
                ->actingAs($repository)
                ->get('/api/v1/repositories')
                ->assertStatus(200);

        //Remove fake repository
        $repository->delete();
    }

    /**
     * Test: should return all the subjects of a given repository
     */
    public function testGetSubjects()
    {
        //Create fake repository
        $repository = factory(Respository::class)->create();
        $tokenResult = $repository->createToken('Personal Access Token');

        //Call
        $this->withHeaders(['Authorization' => 'Bearer '.$tokenResult->accessToken])
                ->actingAs($repository)
                ->get('/api/v1/repository/'.$repository->id.'2/subjects')
                ->assertStatus(200);

        //Remove fake repository
        $repository->delete();
    }

    /**
     * Test: should return all the projects of a given repository
     */
    public function testGetProjects()
    {
        //Create fake repository
        $repository = factory(Respository::class)->create();
        $tokenResult = $repository->createToken('Personal Access Token');

        //Call
        $this->withHeaders(['Authorization' => 'Bearer '.$tokenResult->accessToken])
                ->actingAs($repository)
                ->get('/api/v1/repository/'.$repository->id.'/projects')
                ->assertStatus(200);

        //Remove fake repository
        $repository->delete();
    }
}
