<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form id="formAddUser" wire:submit.prevent="add" wire:confirm="Xác nhận thêm mới!">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="first_name">Tên <span class="required">*</span></label>
                                <input class="form-control @error('first_name') is-invalid @enderror" type="text" id="first_name" wire:model="first_name" placeholder="Nhập tên" />
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="last_name">Họ <span class="required">*</span></label>
                                <input class="form-control @error('last_name') is-invalid @enderror" type="text" id="last_name" wire:model="last_name" placeholder="Nhập họ" />
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="user_name">Tên tài khoản <span class="required">*</span></label>
                                <input class="form-control @error('user_name') is-invalid @enderror" type="text" id="user_name" wire:model="user_name" placeholder="Nhập tên tài khoản" />
                                @error('user_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="email">E-mail <span class="required">*</span></label>
                                <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" wire:model="email" placeholder="Nhập E-mail" />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="password">Mật khẩu <span class="required">*</span></label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" wire:model="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="role">Role <span class="required">*</span></label>
                                <select class="select2 form-select @error('role') is-invalid @enderror" id="role" wire:model="role">
                                    <option value="">Select</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Basic Layout -->

</div>
<!-- / Content -->