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
                        <th class="text-center">Hình ảnh</th>
                        <th class="text-center">Tên sản phẩm</th>
                        <th class="text-center">Giá sản phẩm</th>
                        <th class="text-center">Mô tả</th>
                        <th class="text-center">Danh mục</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($products as $product)
                    <tr>
                        <td class="text-center">
                            <span>{{ $product->id }}</span>
                        </td>
                        <td class="text-center">
                            <img src="{{ asset($product->images[0]->url) }}" alt="avatar" class="rounded" style="width: 50px;">
                        </td>
                        <td class="text-center text-truncate">
                            {{ $product->name }}
                        </td>
                        <td class="text-center text-truncate">
                            <span>{{ number_format($product->price, 0, ',') }}đ</span>
                        </td>
                        <td class="text-center text-truncate">
                            <span>{{ $product->description }}</span>
                        </td>
                        <td class="text-center text-truncate">
                            <span>{{ $product->category->name }}</span>
                        </td>
                        <td class="text-center cursor-pointer">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" wire:click="openEditModal({{ $product->id }})">
                                        <i class="bx bx-edit-alt me-1"></i> Sửa
                                    </a>
                                    <a class="dropdown-item" wire:click="deleteProduct({{ $product->id }})" wire:confirm="Xác nhận xoá sản phẩm?">
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
                {{ $products->links() }}
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" wire:key="edit-modal">
        <div class="modal-dialog modal-lg">
            <form id="formUpdateProduct" wire:submit.prevent="updateProduct">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="d-flex flex-wrap gap-5 mb-2 mt-2">
                                @if($images)
                                @foreach($images as $index => $image)
                                <div class="position-relative">
                                    <img src="{{ asset($image->url) }}" alt="image" class="d-block rounded" height="100" width="100" />
                                    <button type="button" wire:click="removeImage({{ $index }}, 'images')" class="btn btn-xs btn-danger position-absolute top-0 start-100 translate-middle">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </div>
                                @endforeach
                                @endif

                                @if($uploadedImages)
                                @foreach($uploadedImages as $index => $image)
                                <div class="position-relative">
                                    <img src="{{ $image->temporaryUrl() }}" alt="image" class="d-block rounded" height="100" width="100" />
                                    <button type="button" wire:click="removeImage({{ $index }}, 'uploadedImages')" class="btn btn-xs btn-danger position-absolute top-0 start-100 translate-middle">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </div>
                                @endforeach
                                @endif

                                <div class="position-relative">
                                    <div class="loading-container" wire:loading wire:target="images">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-wrapper d-flex justify-content-end mb-2">
                                <label for="upload" class="btn btn-outline-primary" tabindex="0">
                                    <span class="d-none d-sm-block">Chọn ảnh</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input class="account-file-input" type="file" wire:model="uploadedImages" id="upload" hidden multiple accept="image/png, image/jpeg" />
                                </label>
                            </div>
                        </div>
                        <div>
                            <input class="form-control d-none" type="text" id="id" wire:model="id" />
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