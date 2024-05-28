<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="ps-4 pt-4 mb-0">Hình ảnh</h5>
                <!-- Account -->
                <form id="formAddProduct" wire:submit.prevent="addProduct">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-5 mb-3">
                            @foreach($uploadedImages as $index => $image)
                            <div class="position-relative">
                                <img src="{{ $image->temporaryUrl() }}" alt="image" class="d-block rounded" height="150" width="150" />
                                <button type="button" wire:click="removeImage({{ $index }})" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle">
                                    <i class='bx bx-x'></i>
                                </button>
                            </div>
                            @endforeach

                            <div class="position-relative">
                                <div class="loading-container" wire:loading wire:target="images">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-outline-primary me-2" tabindex="0">
                                <span class="d-none d-sm-block">Chọn ảnh</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input class="account-file-input" type="file" wire:model="images" id="upload" hidden multiple accept="image/png, image/jpeg" />
                            </label>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="name">Tên sản phẩm <span class="required">*</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" wire:model="name" placeholder="Nhập tên sản phẩm" />
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="price">Giá sản phẩm <span class="required">*</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="number" id="price" wire:model="price" placeholder="Nhập giá sản phẩm" />
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category">Danh mục <span class="required">*</span></label>
                            <select class="select2 form-select @error('category') is-invalid @enderror" id="category" wire:model="category">
                                <option value="">Select</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Mô tả <span class="required">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" type="text" id="description" wire:model="description" rows="5" placeholder="Nhập mô tả sản phẩm"></textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    <!-- / Basic Layout -->
</div>
<!-- / Content -->