@extends('layouts.app')

@section('title')
    Print Order
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" >
                <!-- <div class="panel-heading">
                    <h4>Invoice</h4>
                </div> -->
                
                <div class="panel-body" id="printNow">
     <link rel="stylesheet"  href="{{url('/dashboard/css/posreciept.css')}}">
                    <div id="invoice-POS">
                            
                            <center id="top">
                              
                              <div class="info"> 
                    
                              <div id="mid">print order//{{now()->toDateTimeString()}}</div>
                              </div><!--End Info1-->
                              
                              <div class="info"> 
                    
                              <div id="demotext">{{config('app.name')}}</div>
                              </div><!--End Info2-->
                            </center><!--End InvoiceTop-->
                    
                            <div id="mid">
                              <div class="info">
                                <p> 
                                    Address : {{config('restaurant.contact.address')}}</br>
                                    Email   : info@brickspoint.ng</br>
                                    Phone   : {{config('restaurant.contact.phone')}}</br>
                                </p>
                              </div>
                              <span class="info">Order NO : {{str_pad($order->id,4,0,STR_PAD_LEFT)}}</span>
                              <span class="right">Date : {{$order->created_at->toDateString()}}</span>
                            </div><!--End Invoice Mid-->
                            
                            <div id="bot">

					<div id="table">
						<table>
							<tr class="tabletitle">
								<td class="Hours"><h2>Qty</h2></td>
								<td class="item"><h2>Desc</h2></td>
								<td class="Rate"><h2>Rate</h2></td>
								<td class="Rate"><h2>Amount</h2></td>
							</tr>
                            @foreach($order->orderPrice as $orderDetails)
							<tr class="service">
								<td class="tableitem"><p class="itemtext">{{$orderDetails->quantity}}</p></td>
								<td class="tableitem"><p class="itemtext">{{$orderDetails->dish->dish}}</p></td>
								<td class="tableitem"><p class="itemtext">{{config('restaurant.currency.symbol')}} {{number_format($orderDetails->net_price)}}</p></td>
								<td class="tableitem"><p class="itemtext">{{config('restaurant.currency.symbol')}} {{number_format($orderDetails->net_price * $orderDetails->quantity)}}</p></td>
							</tr>
							@endforeach

							<tr class="tabletitle">
								<td></td>
								<td></td>
								<td class="Rate"><h2>Sub Total</h2></td>
								<td class="payment"><h2>{{config('restaurant.currency.symbol')}} {{number_format($order->orderPrice->sum('gross_price'))}}</h2></td>
							</tr>
							<tr class="tabletitle">
								@php
								$ValueAddedTax=$order->orderPrice->sum('gross_price')*7.5/100;
								@endphp
								<td></td>
								<td></td>
								<td class="Rate"><h2>VAT 7.5%</h2></td>
								<td class="payment"><h2>{{config('restaurant.currency.symbol')}} {{number_format($ValueAddedTax)}}</h2></td>
							</tr>
							<tr class="tabletitle">
								@php
								$ServiceCharge=$order->orderPrice->sum('gross_price')*5/100;
								@endphp
								<td></td>
								<td></td>
								<td class="Rate"><h2>Service Charge 5%</h2></td>
								<td class="payment"><h2>{{config('restaurant.currency.symbol')}} {{number_format($ServiceCharge)}}</h2></td>
							</tr>
<hr>
							<tr class="tabletitle">
							    <td></td>
								<td></td>
								<td class="Rate"><strong>Total</strong></td>
								<td class="payment"><strong>{{config('restaurant.currency.symbol')}} {{number_format($order->orderPrice->sum('gross_price')+($order->orderPrice->sum('gross_price')*$order->vat)/100)}}</strong></td>
							</tr>

						</table>
					</div><!--End Table-->
<hr>
					<div id="legalcopy">
						<p class="legal"><strong><center>Thank you for Dining With Us!<br> Please come Again<br><p>you have been Served By : Waiter {{$order->servedBy->id}}</p></center></strong>
						</p>
					</div>

				</div><!--End InvoiceBot-->
				
  </div><!--End Invoice-->

                    
                   <!-- <center>
                        
                        <p>
                            Phone : 
                            <br>
                            Address :  
                            <br>
                            Vat Reg No : {{config('restaurant.vat.vat_number')}}
                            <br>
                            Served By : {{$order->servedBy->name}}
                            <br>
                            Table : {{$order->table_id}}
                            <br>
                            Order NO : {{str_pad($order->id,4,0,STR_PAD_LEFT)}}
                        </p>
                    </center>
                    <div class="m-h-50"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table m-t-30">
                                    <thead>
                                    <tr><th>Quantity</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>T. Price</th>
                                    </tr></thead>
                                    <tbody>
                                    @foreach($order->orderPrice as $orderDetails)
                                    <tr>
                                        <td>{{$orderDetails->quantity}}</td>
                                        <td>{{$orderDetails->dish->dish}} |{{$orderDetails->dishType->dish_type}}
                                        </td>
                                        <td>{{config('restaurant.currency.symbol')}} {{number_format($orderDetails->net_price)}} {{config('restaurant.currency.currency')}}</td>
                                        <td>{{config('restaurant.currency.symbol')}} {{number_format($orderDetails->net_price * $orderDetails->quantity)}} {{config('restaurant.currency.currency')}}</td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="border-radius: 0px;">

                        <div class="">
                            <div class="table-responsive">
                                <table class="">
                                    <tbody>
                                    <tr>
                                        <td class="text-right">Sub Total :</td>
                                        <th class="text-right">{{config('restaurant.currency.symbol')}} {{number_format($order->orderPrice->sum('gross_price'))}} {{config('restaurant.currency.currency')}}</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Vat :</td>
                                        <th class="text-right">{{$order->vat}} %</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Gross Total :</td>
                                        <th class="text-right">{{config('restaurant.currency.symbol')}} {{number_format($order->orderPrice->sum('gross_price')+($order->orderPrice->sum('gross_price')*$order->vat)/100)}} {{config('restaurant.currency.currency')}}</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Payment :</td>
                                        <th class="text-right">{{config('restaurant.currency.symbol')}} {{number_format($order->payment)}} {{config('restaurant.currency.currency')}}</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Change :</td>
                                        <th class="text-right">{{config('restaurant.currency.symbol')}} {{number_format($order->change_amount)}} {{config('restaurant.currency.currency')}}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>-->
                    </div>
                    <hr>
                    
                    <div class="hidden-print">
                        @if($order->status > 2)
                        <div class="pull-right">
                            @if($order->user_id == 0)
                            <a href="#" id="submit" class="btn btn-primary waves-effect waves-light">Submit and Print</a>
                            @else
                                <button id="print" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i>Print</button>
                            @endif
                        </div>
                       @endif
                    </div>
                
            
        </div>
    </div>

@endsection

@section('extra-js')
    <script src="{{url('/dashboard/js/printThis.js')}}"></script>
    <script>
        $(document).ready(function () {
            console.log('Ready............');
            $('#submit').on('click',function () {
                console.log("dsf");
                var configm = confirm('If You submit this order you are not able to edit this order again. Are You sure to submit this Order ?');
                if(configm){
                    $("#printNow").printThis();
                    $.get('/marked-order/{{$order->id}}',function (data) {
//                        console.log(data);
                    })
                }

            });

            $("#print").on('click',function () {
                $("#printNow").printThis();
            })
        })
    </script>
@endsection