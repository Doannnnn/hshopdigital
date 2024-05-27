<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form id="formAddCategory" wire:submit.prevent="addCategory" wire:confirm="Xác nhận thêm mới!">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="name">Tên danh mục<span class="required">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" wire:model="name" placeholder="Nhập tên danh mục" />
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                        @if (session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Basic Layout -->

</div>
<!-- / Content -->