@foreach($data as $k=>$v)
    <dl>
        <dt><a href="/zhubao/detail/{{$v->goods_id}}"><img src="http://uploads.com/{{$v->goods_img}}" width="100" height="100" /></a></dt>
        <dd>
            <h3><a href="/zhubao/detail/{{$v->goods_id}}">{{$v->goods_name}}</a></h3>
            <div class="prolist-price"><strong>¥{{$v->goods_price}}</strong> <span>¥{{$v->goods_markprice}}</span></div>
            <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
        </dd>
        <div class="clearfix"></div>
    </dl>
@endforeach