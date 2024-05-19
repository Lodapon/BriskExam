@extends('layouts.mainlayout')

@section('content')
    <!-- Wrapper Start -->
    <div class="">

        <link rel="stylesheet" href="{{ asset('assets-custom/owlcarousel/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets-custom/owlcarousel/owl.theme.default.min.css') }}">

        <!-- Sidebar  -->
        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <div class="container-fluid">

                <div class="row" id="home">
                    <div class="col-lg-12">
                        @if(session()->get("user") == null)
                            <section class="card-landing-yellow">
                                <div class="col-lg-12">
                                    <h2>BriskExam</h2>
                                    <h6>10,000 exams in your pocket</h6>
                                    <form name="sign" action="/login" method="post">
                                        @csrf
                                        <input type="text" name="usr" placeholder="Email">
                                        <input type="password" name="pwd" placeholder="Password">
                                        <button type="submit" class="btn btn-light">Login</button>
                                    </form>
                                    <div class="row mb-3">
                                        <div class="col-6 col-md-2"><a href="/reset">Forgot Password?</a></div>
                                        <div class="col-6 col-md-4">Don't have an account? <a href="/signup">Signup</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif

                        <section class="card-landing-white" id="about">
                            <div class="col-lg-12">
                                <h2>BriskExam คืออะไร?</h2>
                                <div class="card-body">
                                    <p>Brisk Exam เป็น Platform
                                        ที่เป็นศูนย์รวมคลังข้อสอบจำนวนมากหลากหลายแนวที่เหมาะสำหรับทั้ง ครู อาจารย์
                                        นักเรียน บุคคลทั่วไป ไม่ว่าคุณจะเป็น "ผู้สร้างข้อสอบ" (Creator)
                                        เพื่อแบ่งปันความรู้ที่คุณมี ผ่านแบบฝึกหัด-แบบทดสอบที่สร้างโดยคุณ สำหรับนักเรียน
                                        คนในทีมของคุณ รวมถึงคนทั่วไป หรือคุณจะเป็น "ผู้ทำข้อสอบ" (Examinee)
                                        ที่เข้ามาค้นหาแนวข้อสอบ เพื่อทดสอบตัวเอง ไม่ว่าจะเป็นการเตรียมสอบ สอบเข้า
                                        หรือสมัครงาน ผ่านระบบจำลองการสอบซึ่งมีระบบวิเคราะห์ผล
                                        ชี้จุดอ่อน-จุดแข็งให้สามารถทบทวนความรู้ได้อย่างตรงจุด
                                        เตรียมพร้อมสู่สนามสอบจริง </p>
                                </div>

                                <h2>เริ่มต้นใช้งาน</h2>
                                <p>สมัครสมาชิกและเริ่มเป็นส่วนหนึ่งกับ Brisk Exam เพียง 4 ขั้นตอนสั้นๆ</p>
                                <div class="row">
                                    <div class="col-lg-3 align-items-stretch">
                                        <div class="col" align="center">
                                            <h5>1</h5>
                                            <br>
                                            <div class="media-support-user-img mr-3">
                                                <img class="img-fluid" src="../../assets/images/landing/sign-in.png" alt="">
                                            </div>
                                            <br>
                                            <h5>Sign In</h5>
                                            <br>
                                            <p>กดปุ่ม Sign In ด้านบน หรือคลิก สมัครสมาชิก ที่นี่ เพื่อเข้าสู่หน้าสมัครสมาชิก หรือหากคุณเป็นสมาชิกอยู่แล้ว สามารถเข้าสู่ระบบ เพื่อใช้งานได้เลย</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 align-items-stretch">
                                        <div class="col" align="center">
                                            <h5>2</h5>
                                            <br>
                                            <div class="media-support-user-img mr-3">
                                                <img class="img-fluid" src="../../assets/images/landing/Fillform.png" alt="">
                                            </div>
                                            <br>
                                            <h5>Fill Form</h5>
                                            <br>
                                            <p>เมื่อเข้ามาสู่หน้า สมัครสมาชิก
                                                เลือกประเภทสมาชิก
                                                ที่ต้องการและกรอกข้อมูลให้ครบถ้วนเพื่อประโยชน์ในการวิเคราะห์และนำเสนอข้อสอบทั้งหมดจากคลังข้อสอบ</p>
                                            <p>Creator :
                                                สำหรับผู้ที่ต้องการสร้างแบบฝึกหัดหรือแบบทดสอบเพื่อวางขายให้แก่นักเรียนหรือคนในทีม</p>
                                            <p>Examinee : สำหรับผู้ที่ต้องการค้นหาข้อสอบเพื่อลองทำแบบทดสอบและวิเคราะห์
                                                ประเมินผลอัตโนมัติ</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 align-items-stretch">
                                        <div class="col" align="center">
                                            <h5>3</h5>
                                            <br>
                                            <div class="media-support-user-img mr-3">
                                                <img class="img-fluid" src="../../assets/images/landing/browsing.png" alt="">
                                            </div>
                                            <br>
                                            <h5>Browse/Create your Exam</h5>
                                            <br>
                                            <p>สำหรับ Creator สามารถเลือก สร้างข้อสอบได้จากเมนูด้านบนเพื่อเริ่มสร้างข้อสอบหรือแบบฝึกหัดสำหรับวางจำหน่ายในฐานข้อมูลสำหรับ Examinee สามารถเลือก ทำข้อสอบ ทั้ง Fix Exam และ Mock Exam ตามหัวข้อที่สนใจ</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 align-items-stretch">
                                        <div class="col" align="center">
                                            <h5>4</h5>
                                            <br>
                                            <div class="media-support-user-img mr-3">
                                                <img class="img-fluid" src="../../assets/images/landing/money-transfer.png" alt="">
                                            </div>
                                            <br>
                                            <h5>Add/Receive Credit</h5>
                                            <br>
                                            <p>สำหรับ Creator
                                                หลังจากที่แบบฝึกหัดหรือข้อสอบถูกซื้อโดย Examinee จะได้รับ Credit
                                                ตามราคาที่กำหนดแสดงในหน้า Dashboard
                                                และจะมีการโอนไปยังบัญชีที่กำหนดไว้ทุกสิ้นเดือน</p>
                                            <p>สำหรับ Examinee สามารถเลือกซื้อแบบฝึกหัดหรือข้อสอบมาทำได้โดยใช้บัตรเครดิต
                                                หรือโอนเงินมายังบัญชี xxx-xxxx-xxx (BriskExam) และแจ้งมายังเพจ FB :
                                                BriskExam เพื่อเพิ่ม Credit เข้าไปในบัญชีผู้ใช้</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="card-landing-yellow" id="why">
                            <div class="col-lg-12">
                                <h2>ทำไมต้องใช้ Brisk Exam ?</h2>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4 align-items-stretch">
                                        <div class="col" align="center">
                                            <img class="img-fluid" width="50%" src="../../assets/images/landing/analytic.png" alt="">
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <h5>ระบบวิเคราะห์จุดอ่อน</h5>
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <p>โจทย์ทั้งหมดมีระบบ Tags
                                                ที่ช่วยวิเคราะห์หาจุดอ่อนในการทำข้อสอบแต่ละข้อ
                                                ว่ายังมีจุดอ่อนในหัวข้อหรือบทไหน ทำให้สามารถไปอ่านทวน
                                                หรือเลือกเรียนได้ตรงจุด ไม่เสียเวลา </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 align-items-stretch">
                                        <div class="col" align="center">
                                            <img class="img-fluid" width="50%" src="../../assets/images/landing/peopleDB.png" alt="">
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <h5>เปรียบเทียบคะแนนจากฐานข้อมูลและผู้เข้าสอบ</h5>
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <p>ข้อสอบเข้าทั้งหมดมีฐานข้อมูลและอ้างอิงจากข้อสอบจริง
                                                ทำให้สามารถเปรียบเทียบคะแนนที่ได้กับคะแนนต่ำสุดของปีก่อนหน้า
                                                หรือคะแนนเฉลี่ยจากการสอบที่ผ่านมาได้
                                                และมีการเปรียบเทียบกับผู้เข้าสอบในข้อสอบประเภทเดียวกัน
                                                นอกจากนี้ยังมีค่าสถิติสำคัญๆ อย่างเช่น คะแนนเฉลี่ย ส่วนเบี่ยงเบนมาตรฐาน
                                                ฯลฯ อีกด้วย</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 align-items-stretch">
                                        <div class="col" align="center">
                                            <img class="img-fluid" width="50%" src="../../assets/images/landing/book.png" alt="">
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <h5>คลังข้อสอบจำนวนมาก</h5>
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <p>
                                            คลังข้อสอบที่ประกอบไปด้วยข้อสอบเก่าหลากหลายวิชา รวมถึงเหล่า ติวเตอร์
                                            และอาจารย์ผู้เชี่ยวชาญ พร้อมเฉลยอย่างละเอียด เข้าใจง่าย
                                            นอกจากนี้ยังมีข้อสอบจาก Creator
                                            ที่ได้รับการตรวจสอบคุณภาพของข้อสอบทุกฉบับก่อนที่จะแสดงบน Brisk Exam</p>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4 align-items-stretch">
                                        <div class="col" align="center">
                                            <img class="img-fluid" width="50%" src="../../assets/images/landing/wifi.png" alt="">
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <h5>พกพาสะดวก ทำได้ตลอดเวลา รู้ผลคะแนนทันที</h5>
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <p>เพียงสามารถเข้าถึงอินเตอร์เนต
                                                ก็สามารถทำแบบทดสอบหรือฝึกฝนด้วยแบบฝึกหัดได้ ไม่ว่าจะจากมือถือหรือแท็ปเลต
                                                ไม่จำเป็นต้องพกหนังสือรวมข้อสอบเก่าเล่มหนาหนักไปทุกที่
                                                ไม่ว่าจะเป็นระหว่างเดินทาง ระหว่างนั่งรอเพื่อน
                                                หรือกำลังนั่งรอใครที่ร้านกาแฟในห้าง ทำข้อสอบได้ตลอด 24 ชม. และ
                                                รู้ผลการทดสอบทันทีที่ทำเสร็จ</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 align-items-stretch">
                                        <div class="col" align="center">
                                            <img class="img-fluid" width="50%" src="../../assets/images/landing/clock.png" alt="">
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <h5>ระบบจำลองการสอบเสมือนจริง</h5>
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <p>มีระบบจับเวลาเสมือนการสอบจริง
                                                ช่วยในการวางแผนสำหรับการแบ่งเวลาในการทำข้อสอบและลดความตื่นเต้นเมื่อเจอสนามสอบจริง</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 align-items-stretch">
                                        <div class="col" align="center">
                                            <img class="img-fluid" width="50%" src="../../assets/images/landing/review.png" alt="">
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <h5>ระบบให้คะแนนพร้อมซักถามข้อสงสัย</h5>
                                        </div>
                                        <br>
                                        <div class="col" align="center">
                                            <p>ข้อสอบทั้งหมดแสดงคะแนนความพึงพอใจจากผู้ทำ
                                                ซึ่งสามารถเป็นข้อมูลประกอบการตัดสินใจซื้อ นอกจากนี้ยังสามารถติดต่อมายัง
                                                Brisk Exam FB Page ได้หากมีข้อสงสัย</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="card-landing-white" id="products">
                            <div class="col-lg-12" >
                                <div class="row">
                                    <div class="col-lg-6 align-items-stretch">
                                        <h2>Fix Exam</h2>
                                        <div class="card">
                                            <h4>ข้อสอบแบบระบุข้อแน่นอน</h4>
                                            <br>
                                            <p>ข้อสอบประเภท Fix Exam เป็นข้อสอบที่ระบุข้อไว้แน่นอน
                                                ทุกครั้งที่เข้ามาทำข้อสอบชุดเดิมจะมีเนื้อหาเหมือนเดิม
                                                และมีระบุระดับความยากไว้ที่โจทย์ทุกข้อ
                                                เหมาะสำหรับฝึกฝนหรือเตรียมสอบเบื้องต้น มีทั้งที่สร้างโดย Brisk Exam และ
                                                Creator ผู้เชี่ยวชาญ</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 align-items-stretch">
                                        <div class="card">
                                            <img class="img-fluid" src="../../assets/images/landing/exampencil.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 align-items-stretch">
                                        <div class="card">
                                            <img class="img-fluid" src="../../assets/images/landing/studyhard.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 align-items-stretch">
                                        <h2>Mocking Exam</h2>
                                        <div class="card">
                                            <h4>ข้อสอบจำลองเสมือนจริงตามแนวข้อสอบ</h4>
                                            <br>
                                            <p>ข้อสอบประเภท Mock Exam เป็นข้อสอบที่จำลองตามแนวข้อสอบจริง
                                                เมื่อเรียกทำระบบจะจำลองข้อสอบโดยการสุ่มข้อสอบในคลังข้อสอบที่ตรงกับแนวข้อสอบชุดนั้น
                                                ทั้งเนื้อหา และลำดับที่โจทย์ปรากฏ
                                                มาสร้างเป็นข้อสอบชุดใหม่ที่ไม่เคยมีที่ไหนมาก่อน
                                                เหมาะสำหรับผู้ที่ทำโจทย์ข้อสอบแบบ Fix
                                                หรือข้อสอบเก่ามากจนจำได้แล้วและยังต้องการฝึกฝนกับโจทย์ใหม่ๆนอกเหนือจากข้อสอบเก่าเพิ่มเติม</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="card-landing-yellow" id="pricing">
                            <div class="col-lg-12">
                                <h2 align="center">Pricing</h2>
                                <br>
                                <div class="row">
                                    <div class="col-lg-3 d-flex align-items-stretch">
                                        <div class="iq-card flex-fill">
                                            <div class="iq-card-body text-center rounded">
                                                <span
                                                    class="font-size-16 text-uppercase">Examinee : One time access</span>
                                                <h2 class="mb-4 display-4 font-weight-bolder ">฿20<small
                                                        class="font-size-14 text-muted">/ Fix Exam</small></h2>
                                                <h2 class="mb-4 display-4 font-weight-bolder ">฿50<small
                                                        class="font-size-14 text-muted">/ Mockup Exam</small></h2>
                                                <small>*ข้อสอบ Fix Exam โดย Creator ราคาเป็นไปตามที่ Creator
                                                    กำหนด</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-flex align-items-stretch">
                                        <div class="iq-card flex-fill">
                                            <div class="iq-card-body text-center rounded">
                                                <span class="font-size-16 text-uppercase">Examinee : Subscribtion</span>
                                                <h2 class="mb-4 display-4 font-weight-bolder ">฿100<small
                                                        class="font-size-14 text-muted">/ Month</small></h2>
                                                <p>สามารถทำข้อสอบ Fix Exam และข้อสอบ Mockup โดย Brisk Exam
                                                    ได้ไม่จำกัด </p>
                                                <small>*ข้อสอบ Fix Exam โดย Creator ราคาเป็นไปตามที่ Creator
                                                    กำหนด</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-flex align-items-stretch">
                                        <div class="iq-card flex-fill">
                                            <div class="iq-card-body text-center rounded">
                                                <span class="font-size-16 text-uppercase">Creator</span>
                                                <h2 class="mb-4 display-3 font-weight-bolder ">฿0<small
                                                        class="font-size-14 text-muted">/ Month</small></h2>
                                                <p>สำหรับ Creator ไม่มีค่าใช้จ่ายในการสร้างโจทย์ข้อสอบ (Fix Exam)
                                                    และสามารถสร้างข้อสอบได้ไม่จำกัด แต่มีค่าใช้จ่าย 30%
                                                    ต่อทุกๆยอดขายที่เกิดขึ้น</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-flex align-items-stretch">
                                        <div class="iq-card flex-fill">
                                            <div class="iq-card-body text-center rounded">
                                                <span class="font-size-16 text-uppercase">Organisation</span>
                                                <h2 class="mb-4 display-3 font-weight-bolder ">฿-<small
                                                        class="font-size-14 text-muted">/ Month</small></h2>
                                                <p>สำหรับลูกค้าแบบองค์กร
                                                    ค่าใช้จ่ายขึ้นอยู่กับจำนวนสมาชิกและปริมาณของข้อสอบ กรุณาติดต่อ FB
                                                    Page : Brisk Exam หรือ info@briskexam.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="card-landing-white" id="bookstore">
                            <div class="col-lg-12">
                                <h2>Bookstore</h2>
                                <div id="bookItemContainer" class="owl-carousel">
                                    @foreach( $books as $book )
                                        @include("landing-bookshop-item")
                                    @endforeach
                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper END -->
    <script type="text/javascript" src="{{ asset('assets-custom/owlcarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".owl-carousel").owlCarousel({
                items: 4,
                lazyLoad: true,
                loop: true,
                margin: 5,
                autoplay: true,
                autoplayTimeout: 3000,
            });
        });
    </script>
@endsection
