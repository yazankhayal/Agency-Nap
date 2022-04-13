<div class="ps-cart">
    <a class="ps-cart__toggle" href="{{route('cart')}}"><span><i id="cart_count"></i></span><i
            class="icon-cart3"></i></a>
    <div class="ps-cart__listing">
        <div class="ps-cart__content"  id="cart">
        </div>
        <div class="ps-cart__total">
            <p>{{$lang->NumberOfItems}}:<span id="sub_tota_sa"></span></p>
            <p class="d-none">{{lang_name('Shipping')}}:<span id="shipping"></span></p>
            <p class="d-none">{{lang_name('Taxes')}}:<span id="taxes"></span></p>
            <p>{{$lang->Subtotal}}:<span id="tota_sa"></span></p>
        </div>
        <div class="ps-cart__footer"><a href="{{route('cart')}}">{{$lang->Checkout}}</a></div>
    </div>
</div>
