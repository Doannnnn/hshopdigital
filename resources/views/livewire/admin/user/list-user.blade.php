<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Avatar</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">Tên tài khoản</th>
                        <th class="text-center">Họ</th>
                        <th class="text-center">Tên</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                    <tr>
                        <td class="text-center">
                            <span>{{ $user->id }}</span>
                        </td>
                        <td class="text-center">
                            <img src="{{ $user->avatar ? asset($user->avatar) : '/assets/img/avatars/avatar.jpg' }}" alt="avatar" class="rounded-circle" style="width: 30px;">
                        </td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            <span>{{ $user->user_name }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $user->first_name }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $user->last_name }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $user->role->name }}</span>
                        </td>
                        <td class="text-center cursor-pointer">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" wire:click="openEditModal({{ $user->id }})">
                                        <i class="bx bx-edit-alt me-1"></i> Sửa
                                    </a>
                                    <a class="dropdown-item" wire:click="deleteUser({{ $user->id }})" wire:confirm="Xác nhận xoá khách hàng!">
                                        <i class="bx bx-trash me-1"></i> Xoá
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:key="edit-modal">
        <div class="modal-dialog">
            <form id="formUpdateUser" wire:submit.prevent="updateUser">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin khách hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input class="form-control d-none" type="text" id="id" wire:model="id" />
                        <div class="mb-3">
                            <label class="form-label" for="first_name">Tên <span class="required">*</span></label>
                            <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="first_name" wire:model="first_name" placeholder="Nhập tên" />
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="last_name">Họ <span class="required">*</span></label>
                            <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="last_name" wire:model="last_name" placeholder="Nhập họ" />
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="user_name">Tên tài khoản <span class="required">*</span></label>
                            <input class="form-control @error('user_name') is-invalid @enderror" type="text" id="user_name" wire:model="user_name" placeholder="Nhập tên tài khoản" />
                            @error('user_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">E-mail <span class="required">*</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" wire:model="email" placeholder="Nhập E-mail" />
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="role">Role <span class="required">*</span></label>
                            <select class="select2 form-select @error('role') is-invalid @enderror" id="role" wire:model="role">
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- / Content -->