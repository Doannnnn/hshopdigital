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
                            <img src="{{ $product->image ? asset($product->image) : '/assets/img/avatars/avatar.jpg' }}" alt="avatar" class="rounded" style="width: 50px;">
                        </td>
                        <td class="text-center">
                            {{ $product->name }}
                        </td>
                        <td class="text-center">
                            <span>{{ $product->price }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $product->description }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $product->category->name }}</span>
                        </td>
                        <td class="text-center cursor-pointer">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" wire:click="">
                                        <i class="bx bx-edit-alt me-1"></i> Sửa
                                    </a>
                                    <a class="dropdown-item" wire:click="" wire:confirm="Xác nhận xoá sản phẩm?">
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

</div>
<!-- / Content -->