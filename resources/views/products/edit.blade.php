<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>

        @if(session('success'))
            <div class="alert alert-success container">
                {{ session('success') }}
            </div>
        @elseif(session('warning'))
            <div class="alert alert-warning container">
                {{ session('warning') }}
            </div>
        @endif
        <a href="{{route('products.list')}}"><button class="btn btn-dark float-end" id="add-product-btn">{{__('List')}}</button></a>
    </x-slot>


    {{--    ADD PRODUCT--}}
    <div class="py-12" id="form-new-product">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div class="p-6 text-gray-900">
                    {{ __("Edit product") }}
                    @if($product)


                        <form action="/product-update" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="form-group">
                                <label for="name">{{__('Name')}}:</label>
                                <input id="name" name="name" class="form-control" value="{{$product[0]->name}}">
                                <input type="hidden" value="{{$product[0]->id}}" name="id">

                                <label for="description">{{__('Description')}}:</label>
                                <textarea id="description" name="description" class="form-control">{{$product[0]->description}}</textarea>
                                <div id="image-add" class=" mt-2">
                                    <button class="btn btn-dark btn-sm" type="button">{{__('Add images')}}</button>
                                </div>
                                <div class="mt-2">
                                    <table class="table">
                                        <thead>
                                        <th>{{__('Image')}}</th>
                                        <th>{{__('Title image')}}</th>
                                        <th>{{__('Options')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($product as $image)
                                            @if($image->image_path)
                                                <tr id="id_{{$image->image_id}}">
                                                    <td>
                                                        <a href="{{url('storage/'.$image->image_path)}}" target="_blank"><img src="{{url('storage/'.$image->image_path)}}" alt="{{$image->image_name}}" width="100"/></a>
                                                    </td>
                                                    <td>
                                                        {{$image->image_name}}
                                                    </td>
                                                    <td>
                                                    <button class="btn btn-danger btn-sm delete-image-product" type="button" data-token="{{ csrf_token() }}" data-image="{{$image->image_id}}">{{__('Delete')}}</button>

                                                    </td>
                                                </tr>

                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>


                                </div>

                                <button type="submit" class="btn btn-dark mt-2">{{__('Update Product')}}</button>
                            </div>
                        </form>

                    @endif

                </div>
            </div>
        </div>
    </div>



</x-app-layout>

