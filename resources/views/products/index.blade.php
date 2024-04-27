<x-app-layout>
    <x-slot name="header">
        <button class="btn btn-dark float-end" id="add-product-btn" type="button"><i class="  fa fa-solid fa-plus"></i></button>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>


        @if(session('success'))
            <div class="alert alert-success container mt-3">
                {{ session('success') }}
            </div>
        @elseif(session('warning'))
            <div class="alert alert-warning container mt-3">
                {{ session('warning') }}
            </div>
        @endif

    </x-slot>

    {{--    ADD PRODUCT--}}
    <div class="py-12 hidden" id="form-new-product">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("New product") }}

                    <form action="/product" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{__('Name')}}:</label>
                            <input id="name" name="name" class="form-control">
                            <x-input-error :messages="$errors->get('name')"/>

                            <label for="description">{{__('Description')}}:</label>
                            <textarea id="description" name="description" class="form-control"></textarea>

                            <div id="image-add" class=" mt-2">
                                <button class="btn btn-dark btn-sm" type="button">{{__('Add images')}}</button>
                            </div>


                            <button type="submit" class="btn btn-dark mt-2">{{__('Add Product')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--    LIST PRODUCTS--}}


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

{{--            @php--}}
{{--                app()->setLocale('es');--}}
{{--            @endphp--}}
{{--            {{ env('APP_LOCALE') }}--}}

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="table">
                    <thead>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Description')}}</th>
                    <th>{{__('Image')}}</th>
                    <th>{{__('User created')}}</th>
                    <th>{{__('Created')}}</th>
                    <th>{{__('Updated')}}</th>
                    <th>{{__('Options')}}</th>

                    </thead>
                    <tbody>

                    @foreach ($products->unique(function ($element){ return $element->id;}) as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>

                            @if($product->image_path != null)
                                <td><a href="{{url('storage/'.$product->image_path)}}" target="_blank">
                                        <img src="{{url('storage/'.$product->image_path)}}"
                                             alt="{{$product->image_name}}" width="100"/></a>
                                </td>
                            @else
                                <td>
                                    <img src="https://cdn-icons-png.flaticon.com/256/2659/2659360.png"
                                         alt="no image" width="100"/>
                                </td>
                            @endif
                            <td>{{$product->user_name}}</td>
                            <td>{{$product->created_at}}</td>
                            <td>{{$product->updated_at}}</td>
                            <td>
                                <a href="{{route('product.show',$product->id)}}">
                                    <button class="btn btn-success btn-sm" type="button">{{__('View')}}</button>
                                </a>
                                <a href="{{ route('product.update', $product->id) }}">
                                    <button class="btn btn-warning btn-sm edit-product"
                                            data-resource-id="{{ $product->id }}">{{__('Edit')}}</button>
                                </a>
                                <button class="btn btn-danger btn-sm delete-product"
                                        data-resource-id="{{ $product->id }}"
                                        data-token="{{ csrf_token() }}">{{__('Delete')}}</button>
                            </td>
                        </tr>

                    @endforeach


                    </tbody>
                </table>

                <div class="container justify-content-center align-middle p-3 ">
                    {{ $products->links() }}
                </div>

            </div>
        </div>

    </div>


</x-app-layout>
