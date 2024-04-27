import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function () {

    $('#add-product-btn').click(function () {
        $('#form-new-product').toggle();
    })


//     TODO : delete product
    $('.delete-product').click(function () {
        var id = $(this).data('resource-id');
        var token = $(this).data("token");
        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                url: '/product-delete/',
                type: 'DELETE',
                data: {
                    "_token": token,
                    "id": id,
                },
                then: function (response) {
                    console.log('eliminado');

                },
                error: function (xhr) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
            });
            location.reload();
        }
    });
    let idImage=0;
//Todo:     Add Images Product
    $('#image-add button').click(function () {
        idImage++;
        let addImage = '<div class="mt-1" id="img'+idImage+'">' +
            '<input type="file" name="image_'+idImage+'" class="form-control"> ' +
            '<button class="text-danger float-end" data-image="img'+idImage+'" type="button">Delete</button>\n' +
            '<label for="title-image">title:</label>\n' +
            '<input  id="title-image" name="title_image_'+idImage+'" class="form-control" required> </div>'
        $('#image-add').append(addImage)

        $('#img'+idImage+ ' button' ).click (function (){
            let idDiv=$(this).data("image");
            $('#'+idDiv).remove();

        })

    });

    $('.delete-image-product').click(function (){
        var id = $(this).data('image');
        var token = $(this).data("token");
        if (confirm("Are you sure you want to delete this image?")) {
            $.ajax({
                url: '/image-delete/',
                type: 'DELETE',
                data: {
                    "_token": token,
                    "id": id,
                },
                then: function (response) {
                    console.log('eliminado');


                },
                error: function (xhr) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
            });

            $('#id_'+id).remove()

            location.reload();

        }

    })
    $("input[type='radio'][name='feature']").change(function(){

        var selected = $(this).data('checked');
        var idProduct = $(this).data('product');

        $.ajax({
            url: '/image-feature/',
            type: 'GET',
            data: {
                "id": selected,
                "id_product": idProduct
            },
            then: function (response) {
                console.log('feature');

            },
            error: function (xhr) {

                console.log(xhr.responseText);
            }
        });

    });




})
