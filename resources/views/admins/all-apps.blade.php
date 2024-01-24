@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4 d-inline">Job Applications</h5>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">cv</th>
                <th scope="col">email</th>
                <th scope="col">view job</th>
                <th scope="col">job title</th>
                <th scope="col">Company</th>
                <th scope="col">delete</th>
              </tr>
            </thead>
            <tbody>
                @foreach ( $apps as $app )
                    <tr>
                        <th scope="row">1</th>
                        <td><a class="btn btn-success" href="{{ asset('assets/cvs/'.$app->cv.'') }}">CV</a></td>
                        <td>{{ $app->email }}</td>
                        <td><a class="btn btn-success" href="{{ route('single.job', $app->id) }}">Go to job</a></td>
                        <td>{{ $app->job_title }}</td>
                        <td>{{ $app->company }}</td>
                        <td><a href="#" class="btn btn-danger  text-center ">delete</a></td>
                    </tr>
                @endforeach


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @endsection
