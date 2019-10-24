@extends('layouts.backend')
@section('title')

คุยกับ <?php echo $service_conversation->user->name; ?> งานบริการ<?php echo $service_conversation->service->name; ?> - DECORIQ
@endsection

@section('content')

<?php use \App\Http\Controllers\StoreManager\ServiceMessageController; ?>

<div class="container mt-0">
  <div class="row border-right border-left">
    <div class="col-1 p-3">
      <img class="d-inline"  style="display: block; width: 100%; height: auto; object-fit: cover;" src="/images/<?php echo $service_conversation->service->service_photos[0]->name ?>">
    </div>
    <div class="col-7 border-right p-3">
      <h3 class="mt-2 d-inline"><?php echo $service_conversation->service->name; ?></h3><br>
      <img class="rounded-circle d-inline"  style="width: 30px; height: 30px; border:lightgray 1px solid; object-fit: cover;" src="/images/{{$service_conversation->store->photo->file}}">
      <strong>{{$service_conversation->store->name}}</strong>
    </div>

  <div class="col-4 ">

  </div>
</div>

</div>
<div class="container d-flex flex-wrap align-content-between border p-0" style="height:68vh">
 <div class="col-8 pr-0">

 <div class="row w-100">
   <div class="border-right w-100" id="message-conversation-div"  style="overflow-y:scroll;overflow-x:hidden;height: 61vh;">
     <input type="hidden" id="conversation-id" value="<?php echo $service_conversation->id; ?>">
     <ul class="chat-section">
     <?php $customer_user_id = $service_conversation->user_id; ?>
     <?php foreach($service_conversation->messages as $service_message){
        $isownstore = ServiceMessageController::isOwnStorebyId($service_message->service_conversation->service->store->id,$service_message->user->id);
        if($isownstore==false){ ?>
         <li class="chatmessage" data-message-id="<?php echo $service_message->id; ?>" data-user-id="<?php echo $service_message->user->id; ?>">
           <div class="w-80 p-2">
             <div class="row">
               <div class="col-1 text-right">
                 <img class="rounded-circle d-inline"  style="width: 30px; height: 30px; border:lightgray 1px solid; object-fit: cover;" src="/images/<?php echo $service_message->user->photo->file; ?>">
               </div>
               <div class="col-11 bg-gray p-3">
                 <strong><span class="d-inline"><?php if(empty($service_message->user->firstname)){ echo $service_message->user->name; }else{ echo $service_message->user->firstname.' '.$service_message->user->lastname; } ?></span> </strong> <small class="text-muted">(<?php echo $service_message->created_at->diffForHumans(); ?>)</small><br>
                 <?php echo $service_message->message; ?>
               </div>
             </div>
           </div>
         </li>

       <?php }else{ ?>
       <li class="chatmessage" data-message-id="<?php echo $service_message->id; ?>" data-store-id="<?php echo $service_message->service_conversation->service->store->id; ?>">
         <div class="w-80 p-2">
           <div class="row">
             <div class="col-1 text-right">
               <img class="rounded-circle d-inline"  style="width: 30px; height: 30px; border:lightgray 1px solid; object-fit: cover;" src="/images/<?php echo $service_message->service_conversation->service->store->photo->file; ?>">
             </div>
             <div class="col-11 bg-light p-3">
               <strong><?php echo $service_message->service_conversation->service->store->name; ?></strong> <small class="text-muted">(<?php echo $service_message->created_at->diffForHumans(); ?>)</small><br>
               <?php echo $service_message->message; ?>
             </div>
         </div>
         </div>
        </li>
       <?php } ?>
    <?php } ?>

  </ul>


   </div>
</div>
<div class="row w-100 border-right"  style="height: 6.5vh;">
      <div class="message-input  border-top" style="width:96%;">
  			<div class="wrap">
        <input type="hidden" class="service-id" value="<?php echo $service_conversation->service->id ?>" />
        <input type="hidden" class="conversation-id" value="<?php echo $service_conversation->id ?>" />
        <input type="hidden" class="store-username" value="<?php echo $service_conversation->store->username ?>" />
  			<input type="text" placeholder="เขียนข้อความของคุณที่นี่..." class="message-input-box" required>
  			<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
  			<button class="submit message-input-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
  			</div>
  		</div>

</div>
</div>
<div class="col-4 pt-3" style="height:3vh">
  <div id="service-list">
        <button type="button" class="btn btn-primary w-100 mt-2" data-toggle="modal" data-target="#quote-modal">เสนอราคา</button>
        <br><br>
        <span class="h6">บริการที่กำลังดำเนินการ</span><br>
        <div class="" style="overflow-y:scroll;overflow-x:hidden;height:51vh">
          <?php
           if(!$service_orders->isEmpty()){
           foreach($service_orders as $order){ ?>
            <div class="p-2 mt-2 border">
              <span>#<?php echo $order->id ?>:</span><h4 class="text-primary pl-1 d-inline"><?php echo number_format($order->service_order_quote_price,2); ?> ฿</h4> <small><?php if($order->status['id']==1){ ?>
                <span class="badge badge-pill badge-warning"><?php echo $order->status['name']; ?></span>
              <?php } elseif($order->status['id']==2){ ?>
                <span class="badge badge-pill badge-info"><?php echo $order->status['name']; ?></span>
              <?php } elseif($order->status['id']==3){ ?>
                <span class="badge badge-pill badge-primary"><?php echo $order->status['name']; ?></span>
              <?php } elseif($order->status['id']==4){ ?>
                <span class="badge badge-pill badge-secondary"><?php echo $order->status['name']; ?></span>
              <?php } elseif($order->status['id']==5){ ?>
                <span class="badge badge-pill badge-info"><?php echo $order->status['name']; ?></span>
              <?php } elseif($order->status['id']==6){ ?>
                <span class="badge badge-pill badge-success"><?php echo $order->status['name']; ?></span>
              <?php } elseif($order->status['id']==7){ ?>
                <span class="badge badge-pill badge-danger"><?php echo $order->status['name']; ?></span>
              <?php } elseif($order->status['id']==8){ ?>
                <span class="badge badge-pill badge-dark"><?php echo $order->status['name']; ?></span>
              <?php }?></small><br>

              <span><strong>รายละเอียดงาน: </strong><?php echo strlen($order->service_order_conclusion) > 170 ? substr($order->service_order_conclusion,0,170)."..." : $order->service_order_conclusion; ?></span><br>
              <span><strong>วันส่งงาน: </strong><?php echo date_format(date_create($order->service_order_duedate),"d F Y"); ?></span><br>

              <?php if($order->status->id==1){ ?>
                <a href="/storemanager/store/<?php echo $service_conversation->store->username; ?>/service-order/<?php echo $order->id; ?>" class="btn btn-light btn-sm w-33 border" target="_blank">ดูรายละเอียด</a>
                <button type="button" class="btn btn-secondary btn-sm w-33" name="button">แก้ไข</button>
                <a class="text-primary cancel-service-quote" id="cancel-service-quote-<?php echo $order->id; ?>" data-order-id="<?php echo $order->id; ?>" href="#">ยกเลิก</a>
              <?php }elseif($order->status->id==2){ ?>
                <button type="button" class="btn btn-primary btn-sm w-33 border update-order-button" data-store-username="<?php echo $service_conversation->store->username; ?>" data-enc-order-id="<?php echo Crypt::encrypt($order->id); ?>" data-order-id="<?php echo $order->id; ?>" data-toggle="modal" data-target="#update-order-progress-modal">อัพเดท/ส่งงาน</button>
                <a href="/storemanager/store/<?php echo $service_conversation->store->username; ?>/service-order/<?php echo $order->id; ?>" class="btn btn-light btn-sm w-33 border" target="_blank">ดูรายละเอียด</a>
              <?php }elseif($order->status->id==4){ ?>
                <button type="button" class="btn btn-success btn-sm w-33 border accept-customer-edit-request" id="accept-customer-edit-request-<?php echo $order->id; ?>" data-store-username="<?php echo $service_conversation->store->username; ?>" data-order-id="<?php echo $order->id; ?>">ยอมรับและแก้ไข</button>
                <button type="button" class="btn btn-danger btn-sm w-33 border reject-customer-edit-request" id="reject-customer-edit-request-<?php echo $order->id; ?>" data-store-username="<?php echo $service_conversation->store->username; ?>" data-order-id="<?php echo $order->id; ?>">ปฏิเสธการแก้ไข</button>
                <a href="/storemanager/store/<?php echo $service_conversation->store->username; ?>/service-order/<?php echo $order->id; ?>" class="btn btn-light btn-sm w-33 border" target="_blank">ดูรายละเอียด</a>
              <?php }else{ ?>
                <a href="/storemanager/store/<?php echo $service_conversation->store->username; ?>/service-order/<?php echo $order->id; ?>" class="btn btn-light btn-sm w-33 border" target="_blank">ดูรายละเอียด</a>
              <?php } ?>
            </div>

          <?php } ?><br>
          <center><a href="#">- ดูการเสนอราคาที่ถูกยกเลิกแล้ว -</a></center>
          <?php
          }else{
            echo "<div class='p-2 mt-2' style='border:lightgray 1px dashed'><span>- ไม่มีบริการที่ดำเนินการอยู่ขณะนี้</span></div>";
          } ?>
        </div>
      </div>

</div>
</div>

<!-- Quote Modal -->
  <div class="modal fade" id="quote-modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <form action="/storemanager/store/<?php echo $service_conversation->store->username; ?>/service/<?php echo $service_conversation->service->id; ?>/createservicequote" method="post" enctype="multipart/form-data">
          <input name="_token" value="{{ csrf_token() }}" type="hidden">
        <div class="modal-header">
          <h4 class="modal-title">เสนอราคาบริการ</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

            <div class="form-group">
              <label for="InputServiceQuotePrice">ราคาที่ต้องการ</label>
              <input type="text" name="service_order_quote_price" class="form-control" id="service-quote-price" aria-describedby="Service-Quote-Price-Help" placeholder="ระบุราคาที่ต้องการเสนอราคา" required>
              <small id="service-quote-price-help" class="form-text text-muted">กรุณาระบุราคาที่ต้องการจะเสนอให้ลูกค้าสำหรับบริการนี้</small>
            </div>
            <div class="form-group">
              <label for="TextareaServiceQuoteDescription">รายละเอียดงาน</label>
              <textarea class="form-control" name="service_order_conclusion" id="service-quote-description" rows="2"></textarea>
            </div>
            <div class="form-group">
              <label for="TextareaServiceQuoteDescription">วันส่งงาน</label>
              <input id="datepicker" name="service_order_duedate" width="276" />
            </div>
            <div class="form-group">
              <label for="ServicePhotoFileInput">รูปภาพอ้างอิง (ถ้ามี)</label>
              <input type="file" class="service-order-photo" name="service-order-photo-<?php echo $service_conversation->service->id; ?>" class="mb-5">
              <small id="service-photo-file-input-help" class="mt-0 pt-0 form-text text-muted">ใส่ภาพอ้างอิงหรือภาพตัวอย่างงานที่ลูกค้าต้องการถ้าหากมี</small>
            </div>
            {{ Form::hidden('service_id', Crypt::encrypt($service_conversation->service->id)) }}
            {{ Form::hidden('user_id', Crypt::encrypt($customer_user_id)) }}
            {{ Form::hidden('conversation_id', Crypt::encrypt($service_conversation->id)) }}

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">เสนอราคา</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </form>

      </div>

    </div>
  </div>

  <!-- Update Service Order Progress Modal -->
    <div class="modal fade" id="update-order-progress-modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <form id="updateserviceorderprogressform" method="post" enctype="multipart/form-data">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
          <div class="modal-header">
            <h4 class="modal-title">อัพเดทงาน</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

              <div class="form-group">
                <label for="ProgressUpdateType">รูปแบบการอัพเดท</label>
                <select class="form-control" name="service_order_progress_status_id" id="update-progress-type" required>
                  <option value="">กรุณาเลือก</option>
                  <option value="1">อัพเดทความคืบหน้า</option>
                  <option value="2">ส่งงานที่เสร็จแล้ว</option>
                </select>
                <small id="service-photo-file-input-help" class="mt-0 pt-0 form-text text-muted">เลือกอัพเดทความคืบหน้าหากต้องการแจ้งลูกค้าถึงความคืบหน้าระหว่างการดำเนินงานหรือเลือกส่งงานที่เสร็จแล้ว หากงานนี้เสร็จเรียบร้อยแล้ว</small>
              </div>
              <div class="form-group">
                <label for="​ServiceOrderProgressDescription">รายละเอียดการดำเนินงาน</label>
                <textarea class="form-control" name="description" id="service-order-progress-description" rows="2" required></textarea>
                <small id="service-photo-file-input-help" class="mt-0 pt-0 form-text text-muted">กรอกรายละเอียดของงานที่ได้ทำ</small>
              </div>
              <div class="form-group">
                <label for="ServicePhotoFileInput">รูปภาพอ้างอิง (ถ้ามี)</label>
                <input type="file" class="service-order-progress-photo" id="service-order-progress-photo-file-input" name="service-order-progress-photo">
                <small id="service-photo-file-input-help" class="mt-0 pt-0 form-text text-muted">ใส่ภาพงานที่คืบหน้าหรือผลงานที่สำเร็จแล้ว</small>
              </div>
              {{ Form::hidden('service_order_id') }}
              {{ Form::hidden('conversation_id', Crypt::encrypt($service_conversation->id)) }}

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">อัพเดท</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
          </div>
        </form>

        </div>

      </div>
    </div>


    <!-- Response for Edit Modal -->
      <div class="modal fade" id="response-for-edit-modal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <form id="responseforeditform" method="post" enctype="multipart/form-data">
              <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <div class="modal-header">
              <h4 class="modal-title">รายละเอียดการแก้ไขของงานครั้งที่ ... ของ ...</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                  <label for="ServiceOrderEditRequestTextarea">รายละเอียดสิ่งที่ต้องการการแก้ไข</label>
                  <textarea class="form-control" name="description" id="service-order-progress-description" rows="2" required></textarea>
                  <small id="service-photo-file-input-help" class="mt-0 pt-0 form-text text-muted">กรอกรายละเอียดสิ่งที่ต้องการการแก้ไขให้ชัดเจน และเพื่อให้เข้าใจตรงกันทั้ง 2 ฝ่าย กรุณาระบุรูปภาพของสิ่งที่ต้องการให้แก้ไข</small>
                </div>
                <div class="form-group">
                  <label for="ServicePhotoFileInput">รูปภาพอ้างอิง (ถ้ามี)</label>
                  <input type="file" class="service-order-edit-request-photo" id="service-order-progress-photo-file-input" name="service-order-progress-photo">
                  <small id="service-photo-file-input-help" class="mt-0 pt-0 form-text text-muted">ใส่ภาพสิ่งที่ต้องการแก้ไข</small>
                </div>
                {{ Form::hidden('service_order_id') }}
                {{ Form::hidden('conversation_id', Crypt::encrypt($service_conversation->id)) }}

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">ขอแก้ไขงาน</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
          </form>
          </div>
        </div>
      </div><!-- End Request for Edit Modal -->

@endsection
