@extends('client.layout.client')
@section('title' , 'Tin tức chi tiết')
@section('linkCss')
    <link rel="stylesheet" href="{{asset('client/css/new.css')}}">
@endsection
@section('main-content')
    <div class="newDetail" style="margin-top:50px; margin-bottom:100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <h4 class="card-title" style="font-size: 30px; font-weight:bold">Lượng trứng, sữa, trà nên dùng mỗi ngày</h4>
                        <a href="" class="web"><small style="margin-right: 10px">SỨC KHỎE</small> <small>18/04/2000</small></a>
                        <h4 style="font-size: 15px; font-weight:600">Chúng ta có thể ăn bánh mì, trứng, chuối, uống sữa, trà mỗi ngày, nhưng đừng quên cân đối số lượng, không sử dụng quá nhiều.</h4>
                        <p>Khi cố gắng bổ sung thêm vitamin và khoáng chất từ danh mục, bạn có thể dùng quá liều và gây hại cho sức khỏe của mình.
                            Dưới đây là định lượng thức ăn hằng ngày từ một số nghiên cứu:  
                            <br>   
                            6 lát bánh mì
                            <br>
                            Các hướng dẫn nói rằng một chế độ ăn uống lành mạnh từ 1.800 đến 2.000 calo có thể bao gồm 6 lát bánh mì mỗi ngày. 
                            Nhưng bạn không nên ăn quá 3 lát bánh mì trắng làm từ ngũ cốc tinh chế.
                            <br>
                            1 quả trứng
                            <br>
                            Sẽ rất rủi ro nếu ăn nhiều trứng, đặc biệt là đối với những người bị bệnh tim. Các bác sĩ chuyên khoa khuyên hầu hết mọi người nên ăn một 
                            quả trứng mỗi ngày và ít hơn đối với những người có lượng cholesterol trong máu cao. Nếu bạn có sức khỏe tốt, ăn 7 quả trứng mỗi tuần là định lượng phù hợp.
                            <br>
                            1 quả cam
                            <br>
                            Một quả cam có thể cung cấp đủ vitamin C cho cả ngày. Ăn cam với số lượng lớn dễ gây ra các triệu chứng về đường tiêu hóa, 
                            vì vậy bạn nên tránh ăn loại quả này vào buổi tối.
                            <br>
                            2 quả chuối
                            <br>
                            Chuối cung cấp cho cơ thể các chất dinh dưỡng quan trọng và chất xơ. Bạn có thể ăn 2 quả chuối mỗi ngày như một bữa ăn nhẹ. Loại quả này có tác dụng làm giảm đầy hơi, kiểm soát sự thèm ăn và thay thế đường đã qua chế biến. Tuy nhiên, các chuyên gia cho rằng chỉ ăn chuối vào bữa sáng không đảm bảo đủ năng lượng bởi sau đó bạn sẽ cảm thấy mệt mỏi và đói trở lại.
                            <br>
                            3 ly sữa
                            <br>
                            Các hướng dẫn về chế độ ăn uống khuyến nghị người lớn nên uống 3 cốc hoặc 732 ml sữa mỗi ngày. Tuy nhiên, hãy cẩn thận nếu cơ thể bạn không dung nạp các thành phần có trong sữa, chẳng hạn như lactose.
                            <br>
                            3 tách trà đen
                            <br>
                            Các phân tích khác nhau cho thấy uống 3 tách trà đen mỗi ngày giúp giảm nguy cơ đột quỵ. Tuy nhiên, hãy cẩn thận với đồ uống này và lượng caffeine bạn hấp thụ nếu bạn bị bệnh mất ngủ hoặc các trường hợp chống chỉ định khác.
                            <br>
                            1 thìa cà phê muối
                            <br>
                            Người lớn không nên ăn quá 6g muối mỗi ngày, tương đương 1 thìa cà phê. Định lượng này gồm lượng muối có trong tất cả đồ mặn mà bạn ăn.  
                            Hãy cẩn thận về lượng muối bạn cho trẻ ăn: 1 đến 3 tuổi (2g), 4 đến 6 tuổi (3g), 7 đến 10 tuổi (5g), 11 tuổi trở lên ăn như người lớn.
                            <br>
                            6 thìa cà phê đường
                            <br>
                            Các nhà khoa học đề nghị tiêu thụ không quá 6 thìa cà phê đường mỗi ngày đối với hầu hết phụ nữ. Đàn ông có thể ăn tối đa 9 thìa.
                            Nếu bạn uống một lon nước có đường mỗi ngày mà không cắt giảm lượng calo ở những món khác, bạn có thể tăng tới 7 kg trong vòng 3 năm.
                            <b>An Yên</b> (Theo Brightside)
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="new-feature">
                            <h4 style="margin-left:30px"><b>Bài viết nổi bật</b></h4>
                            <div class="card-group">
                                <div class="card">
                                    <div class="col-md-12" style="margin-bottom: 20px;">
                                        <div class="col-md-4">
                                            <a href=""><img class="card-img-top" src="https://vnn-imgs-f.vgcloud.vn/2022/01/16/10/t1-240x160.jpg" width="95px" alt="Card image cap"></a>                                      
                                        </div>
                                        <div class="col-md-8">
                                             <div class="card-body">
                                                <a href=""><h4 class="card-title" style="font-size: 16px;">Lượng trứng, sữa, trà nên dùng mỗi ngày</h4></a>
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="card">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <a href=""><img class="card-img-top" src="https://vnn-imgs-f.vgcloud.vn/2022/01/16/10/t1-240x160.jpg" width="95px" alt="Card image cap"></a>                                      
                                        </div>
                                        <div class="col-md-8">
                                             <div class="card-body">
                                                <a href=""><h4 class="card-title" style="font-size: 16px;">Lượng trứng, sữa, trà nên dùng mỗi ngày</h4></a>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection