@extends('layouts.app')
@section('title', 'Users')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Website') }}</th>
                            <th>{{ __('Register Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $key => $user)
                        <tr>
                            <td scope="row">{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name ?? 'Default' }}</td>
                            <td>{{ $user->email ?? 'default@yourmail.com' }}</td>
                            <td>{{ $user->website ?? 'https://yourdomain.com' }}</td>
                            <td>{{ $user->created_at->format('d-m-Y') ?? '10-05-2021' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="5">
                                <h5 class="text-danger">{{ __('No Data Found!!') }}</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection