<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="overflow-x-auto">
            <form method="GET" action="{{ route('product.index') }}" class="flex flex-wrap items-center gap-3">

                <a href="{{ route('product.create')}}"
                    class="mb-8 mt-4 px-6 py-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Add product data
                </a>

                <!-- Dropdown Filter Unit -->
                <select name="filter_unit" class="rounded-lg border border-gray-300 px-7 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Unit</option>
                    @foreach ($units as $unit)
                    <option value="{{ $unit }}" {{ request('filter_unit') == $unit ? 'selected' : '' }}>
                        {{ $unit }}
                    </option>
                    @endforeach
                </select>

                <!-- Dropdown Filter Type -->
                <select name="filter_type" class="rounded-lg border border-gray-300 px-7 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Type</option>
                    @foreach ($types as $type)
                    <option value="{{ $type }}" {{ request('filter_type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                    @endforeach
                </select>

                <!-- Dropdown Filter Producer -->
                <select name="filter_producer" class="rounded-lg border border-gray-300 px-7 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Semua Producer</option>
                    @foreach ($producers as $producer)
                    <option value="{{ $producer }}" {{ request('filter_producer') == $producer ? 'selected' : '' }}>
                        {{ $producer }}
                    </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Filter
                </button>
            </form>

            <!-- search bar  -->
            <form method="GET" action="{{ route('product.index') }}" class="mb-4 flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Cari</button>
            </form>

            <table class="min-w-full border border-collapse border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        @php
                        $sort = request('sort');
                        $direction = request('direction') === 'asc' ? 'desc' : 'asc';
                        @endphp

                        {{-- ID --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'id', 'direction' => $direction] + request()->query()) }}" class="flex items-center justify-between w-full select-none ">
                                <span>ID</span>
                                <span class="flex flex-col items-center leading-none ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'id' && request('direction') === 'asc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 ">
                                        <path fill-rule="evenodd" d="M5 12l5-5 5 5H5z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'id' && request('direction') === 'desc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 -mt-1">
                                        <path fill-rule="evenodd" d="M5 8l5 5 5-5H5z" />
                                    </svg>
                                </span>
                            </a>
                        </th>

                        {{-- Product Name --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'product_name', 'direction' => $direction] + request()->query()) }}" class="flex items-center justify-between w-full select-none ">
                                <span>Product Name</span>
                                <span class="flex flex-col items-center leading-none ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'product_name' && request('direction') === 'asc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 ">
                                        <path fill-rule="evenodd" d="M5 12l5-5 5 5H5z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'product_name' && request('direction') === 'desc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 -mt-1">
                                        <path fill-rule="evenodd" d="M5 8l5 5 5-5H5z" />
                                    </svg>
                                </span>
                            </a>
                        </th>

                        {{-- Product Detail (tidak sortable) --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Product Detail</th>

                        {{-- Unit --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'unit', 'direction' => $direction] + request()->query()) }}" class="flex items-center justify-between w-full select-none ">
                                <span>Unit</span>
                                <span class="flex flex-col items-center leading-none ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'unit' && request('direction') === 'asc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 ">
                                        <path fill-rule="evenodd" d="M5 12l5-5 5 5H5z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'unit' && request('direction') === 'desc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 -mt-1">
                                        <path fill-rule="evenodd" d="M5 8l5 5 5-5H5z" />
                                    </svg>
                                </span>
                            </a>
                        </th>

                        {{-- Type --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'type', 'direction' => $direction] + request()->query()) }}" class="flex items-center justify-between w-full select-none ">
                                <span>Type</span>
                                <span class="flex flex-col items-center leading-none ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'type' && request('direction') === 'asc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 ">
                                        <path fill-rule="evenodd" d="M5 12l5-5 5 5H5z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'type' && request('direction') === 'desc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 -mt-1">
                                        <path fill-rule="evenodd" d="M5 8l5 5 5-5H5z" />
                                    </svg>
                                </span>
                            </a>
                        </th>

                        {{-- Information --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'information', 'direction' => $direction] + request()->query()) }}" class="flex items-center justify-between w-full select-none ">
                                <span>Information</span>
                                <span class="flex flex-col items-center leading-none ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'unit' && request('direction') === 'asc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 ">
                                        <path fill-rule="evenodd" d="M5 12l5-5 5 5H5z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'unit' && request('direction') === 'desc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 -mt-1">
                                        <path fill-rule="evenodd" d="M5 8l5 5 5-5H5z" />
                                    </svg>
                                </span>
                            </a>
                        </th>

                        {{-- Qty --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'qty', 'direction' => $direction] + request()->query()) }}" class="flex items-center justify-between w-full select-none ">
                                <span>Qty</span>
                                <span class="flex flex-col items-center leading-none ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'qty' && request('direction') === 'asc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 ">
                                        <path fill-rule="evenodd" d="M5 12l5-5 5 5H5z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'qty' && request('direction') === 'desc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 -mt-1">
                                        <path fill-rule="evenodd" d="M5 8l5 5 5-5H5z" />
                                    </svg>
                                </span>
                            </a>
                        </th>

                        {{-- Producer --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">
                            <a href="{{ route('product.index', ['sort' => 'producer', 'direction' => $direction] + request()->query()) }}" class="flex items-center justify-between w-full select-none ">
                                <span>Producer</span>
                                <span class="flex flex-col items-center leading-none ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'producer' && request('direction') === 'asc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 ">
                                        <path fill-rule="evenodd" d="M5 12l5-5 5 5H5z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="{{ $sort === 'producer' && request('direction') === 'desc' ? '#000000' : '#9197a0ff' }}"
                                        class="w-3.5 h-3.5 -mt-1">
                                        <path fill-rule="evenodd" d="M5 8l5 5 5-5H5z" />
                                    </svg>
                                </span>
                            </a>
                        </th>

                        {{-- Aksi (tidak sortable) --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if (session('success'))
                    <div id="alert-success"
                        class="mb-8 mt-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                        {{ session('success') }}
                    </div>

                    <script>
                        // hilangkan otomatis setelah 3 detik
                        setTimeout(() => {
                            document.getElementById('alert-success')?.remove();
                        }, 3000);
                    </script>
                    @endif


                    @forelse ($data as $item)
                    <tr class="bg-white">
                        <td class="px-4 py-2 border border-gray-200">{{ $item->id }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->product_name }}</td>
                        <td class="border border-gray-200 px-4 py-2 over:text-blue-500 hover:underline">
                            <a href="{{ route('product.detail', $item->id) }}">
                                {{ $item->product_name}}
                            </a>
                        </td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->unit }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->type }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->information }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->qty }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->producer }}</td>
                        <td class="px-4 py-2 border border-gray-200">
                            <a href="{{ route('product.edit', $item->id) }}"
                                class="px-2 text-blue-600 hover:text-blue-800">Edit</a>
                            <button
                                class="px-2 text-red-600 hover:text-red-800"
                                onclick="confirmDelete({{ $item->id }}, '{{ route('product.destroy', $item->id) }}')">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <p colspan="9" class="py-6 text-center text-2xl font-bold text-red-600">
                            No products found
                        </p>
                    </tr>
                    @endforelse
                    <!-- Tambahkan baris lainnya sesuai kebutuhan -->
                </tbody>
            </table>
            <div class="mt-4">
                <!-- {{ $data->links() }} -->
                {{ $data->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(id, deleteUrl) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini ? ')) {
                // Jika user mengonfirmasi, kita dapat membuat form dan mengirimkan permintaan delete
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                // Tambahkan CSRF token
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                // Tambahkan method spoofing untuk DELETE (karena HTML form hanya mendukung GET dan POST)
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                // Tambahkan form ke body dan submit
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

</x-app-layout>