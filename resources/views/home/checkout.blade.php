@extends('home/base')


@section('content')
<div class="py-3 bg-dark text-white">
    <div class="container">
         <h6>Home/Cart/</h6>
         <h2>Checkout</h2>
     </div>
 </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-9">

                @if ($address)
                <div class="card">
                    <div class="card-body">
                    <form action="{{ route('makePayment')}}" method="POST">
                            @csrf
                            <select name="address_id" id="" class="form-control" onchange="this.form.submit();">
                                    @foreach ($address as $a)
                            <option value="{{$a->id}}">{{$a->name}} {{ $a->contact }} | {{$a->area }} ({{$a->city}}, {{$a->state}})</option>
                                    @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        Create your Address Records

                        <form action="{{ route('insert_checkout')}}" method="POST">
                            @csrf
                           <div class="row">
                            <div class="form-group col">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group col">
                                <label for="">contact</label>
                                <input type="text" name="contact" class="form-control">
                            </div>
                           </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="">area</label>
                                    <input type="text" name="area" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label for="">street</label>
                                    <input type="text" name="street" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="">city</label>
                                    <input type="text" name="city" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label for="">state</label>
                                    <input type="text" name="state" class="form-control">
                                </div>
                                <div class="form-group col">
                                    <label for="">pincode</label>
                                    <input type="text" name="pincode" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <input type="submit" value="Make Payment" class="btn btn-success btn-block">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <ul class="list-group">
                    <?php $final =0;?>
                    @foreach ($orderitem as $oi)
                   
                <li class="list-group-item list-group-item-action small">{{$oi->pro->title}} <span class="float-right">{{$oi->pro->price}}*{{$oi->qty}} = <?php echo $total = $oi->pro->price * $oi->qty; $final += $total; ?> </span></li>

                         
                    @endforeach
                    <li class="list-group-item list-group-item-action bg-primary text-white"><strong class="h5">Total Amount: {{$final}}</strong> </li>
                </ul>
            </div>
        </div>
    </div>
@endsection