@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<script type="text/javascript">

  var prefix1 = 'numProbC'; // number of problem with choices ans
  var prefix2 = 'numProbD'; // number of problem witn describtive ans
  var createPressed = 0;
  var existProbNum = 0;
  var existProbNumC = 0;
  var existProbNumD = 0;
  
  function createInputField() {
    // For see how many time the button is pressed
    createPressed += 1;
    // document.getElementById("createPressed").innerHTML = createPressed;
    var probnum = 0;
    var numProbC = 0;
    var numProbD = 0; 
    
    if (createPressed>1) { //to clear old input field
      for (i=1; i<=existProbNumC; i++){
        document.getElementById('inputProbC').remove();
      }
      existProbNum = 0;
      existProbNumC = 0;
      for (i=1; i<=existProbNumD; i++){
        document.getElementById('inputProbD').remove();
      }
      existProbNumD = 0;
    }

    numProbC = parseInt(document.getElementById("numProbC").value)
    numProbD = parseInt(document.getElementById("numProbD").value)
    probnum = numProbC + numProbC
    document.getElementById("probnumC").innerHTML = numProbC;
    document.getElementById("probnumD").innerHTML = numProbD;

    // Create Input for Problem Choices
    for (i=1; i<=numProbC; i++) {
      var div = document.createElement('div');
      div.innerHTML = '<div id="inputProbC"><div class="form-group row"><div class="col-12"><label for="exampleFormControlTextarea1">โจทย์คำถามแบบมีตัวเลือกข้อ ' +i+ ' </label><textarea class="form-control" id="txtAreaProbC' +i+'"'+ 'rows="5"></textarea></div></div><div class="form-group row"><div class="col-3"><div class="custom-file"><input type="file" class="custom-file-input" id="picProbC' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div><div class="col-7"></div><div class="col-2"><select class="form-control form-control-sm" id="lvlProbC' +i+'"'+ '><option selected="">เลือกระดับความยาก</option><option value="easy">ง่าย</option><option value="medium">ปานกลาง</option><option value="hard">ยาก</option></select></div></div><div class="form-group row"><div class="col-12"><p>Answer</p><div class="list-group"><a href="#" class="list-group-item list-group-item-action "><div class="form-group row"><div class="col-auto">1)</div><div class="col-8"><input class="form-control" id="choice1ProbC' +i+'"'+ 'placeholder="ตัวเลือกคำตอบที่1"></div><div class="col-auto">Or</div><div class="col-3" ><div class="custom-file"><input type="file" class="custom-file-input" id="picChoice1ProbC' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div></div></a><a href="#" class="list-group-item list-group-item-action "><div class="form-group row"><div class="col-auto">2)</div><div class="col-8"><input class="form-control" id="choice2ProbC' +i+'"'+ 'placeholder="ตัวเลือกคำตอบที่2"></div><div class="col-auto">Or</div><div class="col-3" ><div class="custom-file"><input type="file" class="custom-file-input" id="picChoice2ProbC' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div></div></a><a href="#" class="list-group-item list-group-item-action active"><div class="form-group row"><div class="col-auto">3)</div><div class="col-8"><input class="form-control" id="choice3ProbC' +i+'"'+ 'placeholder="ตัวเลือกคำตอบที่3"></div><div class="col-auto">Or</div><div class="col-3" ><div class="custom-file"><input type="file" class="custom-file-input" id="picChoice3ProbC' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div></div></a><a href="#" class="list-group-item list-group-item-action "><div class="form-group row"><div class="col-auto">4)</div><div class="col-8"><input class="form-control" id="choice4ProbC' +i+'"'+ 'placeholder="ตัวเลือกคำตอบที่4"></div><div class="col-auto">Or</div><div class="col-3" ><div class="custom-file"><input type="file" class="custom-file-input" id="picChoice4ProbC' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div></div></a></div></div></div><div class="form-group row"><div class="col-12"><label for="exampleFormControlTextarea1">Tags</label><input class="form-control" id="tagsProbC' +i+'"'+ ' placeholder="Tags ที่เกี่ยวข้องกับโจทย์ข้อ ' +i+ '"></div></div><div class="form-group row"><div class="col-12"><label for="exampleFormControlTextarea1">เฉลยละเอียดข้อ ' +i+'</label><textarea class="form-control" id="solutionProbC' +i+'"'+ ' rows="5"></textarea></div></div><div class="form-group row"><div class="col-3"><div class="custom-file"><input type="file" class="custom-file-input" id="solutionPicProbC' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div></div><hr><br></div>' ;
      document.getElementById('probCPanel').appendChild(div);
      existProbNumC +=1;
    }

    for (i=1; i<=numProbD; i++) {
      var div = document.createElement('div');
      div.innerHTML = '<div id="inputProbD"><div class="form-group row"><div class="col-12"><label for="exampleFormControlTextarea1">โจทย์คำถามแบบเติมคำข้อ ' +i+ '</label><textarea class="form-control" id="txtAreaProbD' +i+'"'+ ' rows="5"></textarea></div></div><div class="form-group row"><div class="col-3"><div class="custom-file"><input type="file" class="custom-file-input" id="picProbD' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div><div class="col-7"></div><div class="col-2"><select class="form-control form-control-sm" id="lvlProbD' +i+'"'+ '><option selected="">เลือกระดับความยาก</option><option value="easy">ง่าย</option><option value="medium">ปานกลาง</option><option value="hard">ยาก</option></select></div></div><div class="form-group row"><div class="col-12"><p>Answer</p><div class="list-group"><a href="#" class="list-group-item list-group-item-action active"><div class="form-group row"><div class="col-8"><input class="form-control" id="ansProbD' +i+'"'+ ' placeholder="คำตอบของข้อสอบเติมคำข้อนี้"></div><div class="col-auto">Or</div><div class="col-3" ><div class="custom-file"><input type="file" class="custom-file-input" id="picAnsProbD' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div></div></a></div></div></div><div class="form-group row"><div class="col-12"><label for="exampleFormControlTextarea1">Tags</label><input class="form-control" id="tagsProbD' +i+'"'+ ' placeholder="Tags ที่เกี่ยวข้องกับโจทย์ข้อ' +i+'"'+ '></div></div><div class="form-group row"><div class="col-12"><label for="exampleFormControlTextarea1">เฉลยละเอียดข้อ ' +i+'</label><textarea class="form-control" id="solutionProbD' +i+'"'+ ' rows="5"></textarea></div></div><div class="form-group row"><div class="col-3"><div class="custom-file"><input type="file" class="custom-file-input" id="solutionPicProbC' +i+'"'+ '><label class="custom-file-label" for="customFile">Upload Picture</label></div></div></div><hr><br></div>'
      document.getElementById('probDPanel').appendChild(div);
      existProbNumD +=1;
    }


  }
</script>

 <div class="wrapper">
    <!-- Sidebar  -->

    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Input ข้อสอบ Mockup</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="iq-card-body">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label>รายวิชา</label>
                                <select id="subject" class="form-control form-control-sm mb-3">
                                    <option selected="none">เลือกวิชา</option>
                                    <option value="math">คณิตศาสตร์</option>
                                    <option value="sci">วิทยาศาสตร์</option>
                                    <option value="physic">ฟิสิกส์</option>
                                    <option value="chem">เคมี</option>
                                    <option value="bio">ชีวะวิทยา</option>
                                    <option value="eng">ภาษาอังกฤษ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>ชื่อข้อสอบ</label>
                                <select id="name" class="form-control form-control-sm mb-3">
                                    <option selected="none">เลือกชื่อข้อสอบ</option>
                                    <option value="pat">PAT</option>
                                    <option value="gat">GAT</option>
                                    <option value="onet">ONET</option>
                                    <option value="saman">9 วิชาสามัญ</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>ปีที่สอบ</label>
                                <select id="year" class="form-control form-control-sm mb-3">
                                    <option selected="none">เลือกปี</option>
                                    <option value="2563">2563</option>
                                    <option value="2562">2562</option>
                                    <option value="2561">2561</option>
                                    <option value="2560">2560</option>
                                    <option value="2559">2559</option>
                                    <option value="2558">2558</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>เดือนที่สอบ</label>
                                <select id="month" class="form-control form-control-sm mb-3">
                                    <option selected="none">เลือกเดือน</option>
                                    <option value="1">มกราคม</option>
                                    <option value="2">กุมภาพันธ์</option>
                                    <option value="3">มีนาคม</option>
                                    <option value="4">เมษายน</option>
                                    <option value="5">พฤษภาคม</option>
                                    <option value="6">มิถุนายน</option>
                                    <option value="7">กรกฏาคม</option>
                                    <option value="8">สิงหาคม</option>
                                    <option value="9">กันยายน</option>
                                    <option value="10">ตุลาคม</option>
                                    <option value="11">พฤษจิกายน</option>
                                    <option value="12">ธันวาคม</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                              <label>ข้อสอบตัวเลือก</label>
                              <input type="text" id='numProbC' class="form-control" placeholder="จำนวนข้อ">
                            </div>
                            <div class="col-lg-4">
                              <label> <br></label>
                              <input type="text" class="form-control" placeholder="จำนวนตัวเลือก">
                            </div>
                            <div class="col-lg-4">
                              <label>ข้อสอบเติมคำ</label>
                              <input type="text" id='numProbD' class="form-control" placeholder="จำนวนข้อ">
                            </div>
                        </div>
                        <br>
                        <!-- Create Pressed: <a id="createPressed"></a> -->
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onClick="createInputField()">Create</button>
                </div>
              </div> 
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
                  <div class="iq-card">
                      <div class="iq-card-header d-flex justify-content-between">
                          <div class="iq-header-title">
                              <h4 class="card-title">สร้างข้อสอบตัวเลือก</h4>
                          </div>
                          จำนวนข้อ: <a id="probnumC"></a>
                      </div>
                      <div class="iq-card-body">
                          <div class="iq-card-body">
                            <div id="probCPanel">
                                <!-- for Problem with Choices field input -->
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
                  <div class="iq-card">
                      <div class="iq-card-header d-flex justify-content-between">
                          <div class="iq-header-title">
                              <h4 class="card-title">สร้างข้อสอบเติมคำ</h4>
                          </div>
                          จำนวนข้อ: <a id="probnumD"></a>
                      </div>
                      <div class="iq-card-body">
                          <div class="iq-card-body">
                            <div id="probDPanel"> 
                                <!-- for Problem with Describtive Answer field input -->
                            </div>
                          </div>
                      </div>
                  </div>
                  <button type="button" class="btn btn-primary btn-block">Save</button>
              </div>
          </div>
          <br>
       </div>
    </div>
 </div>

&nbsp;


 <!-- Wrapper END -->
 <!-- Footer -->

@endsection
