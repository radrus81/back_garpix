@forelse ($products as $key=>$product)
<tr class="d-flex">
    <th class="col-1">{{++$key}}</th>
    <td class="col-3">{{$product->name}}</td>
    <td class="col-2">{{$product->amount}}</td> 
    <td class="col-1">
        @if(Route::currentRouteName() === 'basket' || isset($deleteProduct))   
        <i class="fas fa-trash fa-lg text-danger" 
           title="Удалить из корзины" 
           onclick="removeProductToBasket({{$product->id}})"></i>
        <span class="spinner-border spinner-border-sm spinnerdel_{{$product->id}}"  role="status" aria-hidden="false" style="display: none;"></span>
        @else
        <i class="fas fa-shopping-basket fa-lg text-success" 
           title="Добавить в корзину" 
           onclick="addProductToBasket({{$product->id}})"></i>
        <span class="spinner-border spinner-border-sm spinneradd_{{$product->id}}"  role="status" aria-hidden="false" style="display: none;"></span>
        @endif
    </td> 
</tr> 
@empty
<tr>
    <td colspan="4" class="text-center">
        <div class="alert alert-danger">Товаров нет!</div>
    </td>            
</tr>   
@endforelse
@if (Route::currentRouteName() === 'basket' || isset($deleteProduct))
<tr class="d-flex">
    <td class="col-1" ></td>
    <td class="col-3" colspan="2">Всего:</td>
    <td class="col-3">{{$totalAmount}}</td>
</tr>
@endif