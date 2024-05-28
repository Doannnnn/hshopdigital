<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ session('title') }} /</span> {{ $directory }} </h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-body">
                    <form id="formAddCategory" wire:submit.prevent="addCategory">
                        <div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="category_type">Chọn loại danh mục <span class="required">*</span></label>
                                <select class="form-select" id="category_type" wire:model="category_select" wire:change="updateCategorySelect">
                                    <option value="main_category">Thêm danh mục chính</option>
                                    <option value="sub_category">Thêm danh mục phụ</option>
                                    <option value="both">Thêm cả 2 danh mục</option>
                                </select>
                            </div>

                            <!-- Danh mục chính -->
                            @if ($selected_value != 'sub_category')
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="main_category">Danh mục chính <span class="required">*</span></label>
                                <input class="form-control @error('main_category') is-invalid @enderror" type="text" id="main_category" wire:model="main_category" placeholder="Nhập tên danh mục chính" />
                                @error('main_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <!-- Select danh mục chính -->
                            @if ($selected_value == 'sub_category')
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="main_category_select">Danh mục chính <span class="required">*</span></label>
                                <select class="form-select" id="main_category_select" wire:model="main_category_select">
                                    @foreach ($mainCategories as $mainCategory)
                                    <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('main_category_select')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

                            <!-- Danh mục phụ -->
                            @if ($selected_value != 'main_category')
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="sub_category">Danh mục phụ <span class="required">*</span></label>
                                <input class="form-control @error('sub_category') is-invalid @enderror" type="text" id="sub_category" wire:model="sub_category" placeholder="Nhập tên danh mục phụ" />
                                @error('sub_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif

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