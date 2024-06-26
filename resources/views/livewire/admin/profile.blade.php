<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="ps-4 pt-4 mb-0">Ảnh đại diện</h5>
                <!-- Account -->
                <form id="formProfile" wire:submit.prevent="updateProfile">
                    <div class=" card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div class="loading-container" wire:loading wire:target="avatar">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <img src="{{ $avatar ? $avatar->temporaryUrl() : (session('user')->avatar ? asset(session('user')->avatar) : asset('/assets/img/avatars/avatar.jpg')) }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                @error('avatar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <p class="text-muted mb-4">Được phép JPG, GIF hoặc PNG. Kích thước tối đa 800K</p>

                                <label for="upload" class="btn btn-outline-primary me-2" tabindex="0">
                                    <span class="d-none d-sm-block">Tải ảnh mới </span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input class="account-file-input" type="file" wire:model="avatar" id="upload" hidden accept="image/png, image/jpeg" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label" for="full_name">Họ và Tên <span class="required">*</span></label>
                                    <input class="form-control @error('full_name') is-invalid @enderror" type="text" id="full_name" wire:model="full_name" />
                                    @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Số điện thoại <span class="required">*</span></label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="text" id="phone" wire:model="phone" />
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="email">E-mail <span class="required">*</span></label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="text" id="email" wire:model="email" />
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6" style="border: solid 1px #94979a;">
                                <div class="pb-3 pt-3">
                                    <label>Thay đổi mật khẩu (bỏ trống nếu không thay đổi).</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="current_password">Mật khẩu hiện tại</label>
                                    <input class="form-control @error('current_password') is-invalid @enderror" type="password" id="current_password" wire:model="current_password" />
                                    @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="new_password">Mật khẩu mới</label>
                                    <input class="form-control @error('new_password') is-invalid @enderror" type="password" id="new_password" wire:model="new_password" />
                                    @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="confirm_new_password">Xác nhận mật khẩu mới</label>
                                    <input class="form-control @error('confirm_new_password') is-invalid @enderror" type="password" id="confirm_new_password" wire:model="confirm_new_password" />
                                    @error('confirm_new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Lưu thay đổi</button>
                            @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->