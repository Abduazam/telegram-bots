<div class="block block-rounded">
    <div class="block-content">
        <div class="filter-table pb-4">
            <div class="row w-100 h-100 m-0 p-0">
                <div class="col-md-3 col-4 ps-0">
                    <x-helpers.search />
                </div>
                <div class="col-md-7 col-4 px-0">
                    <!-- Filters -->
                    <div class="row w-100 h-100 p-0 m-0">
                        <div class="col-md-3 col-6 ps-0">
                            <x-helpers.per-page />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap mb-4">
            <table class="own-table w-100">
                <thead>
                <tr>
                    <th class="text-center">id</th>
                    <th class="text-center">chat id</th>
                    <th class="text-center">first name</th>
                    <th class="text-center">username</th>
                    <th class="text-center">phone number</th>
                    <th class="text-center">created at</th>
                    <th class="text-center">status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr wire:key="user-row-{{ $user->id }}">
                        <td class="text-center">{{ $user->id }}</td>
                        <td class="text-center">{{ $user->chat_id }}</td>
                        <td class="text-center">{{ $user->getFirstName() }}</td>
                        <td class="text-center">{!! $user->getUsername() !!}</td>
                        <td class="text-center">{{ $user->phone_number }}</td>
                        <td class="text-center">{{ $user->created_at }}</td>
                        <td class="text-center">{!! $user->getStatus() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <x-helpers.pagination-navbar :data="$users" />
    </div>
</div>
