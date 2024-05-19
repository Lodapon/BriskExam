@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<script type="text/javascript">
  var addSectionPressed = 1;
  function addSection() {
    // count when addSection button is pressed
    addSectionPressed += 1;
    document.getElementById("sectionshow").innerHTML = addSectionPressed;

    let div = document.createElement('div');
    div.innerHTML = '<div class="form-group row"><div class="col-lg-4"><input type="text" id="numProbC' +addSectionPressed+ '"'+'class="form-control" placeholder="จำนวนข้อสอบตัวเลือก"></div><div class="col-lg-4"><input type="text" id="numC' +addSectionPressed+ '"'+'class="form-control" placeholder="จำนวนตัวเลือก"></div><div class="col-lg-4"><input type="text" id="numProbD' +addSectionPressed+ '"'+' class="form-control" placeholder="จำนวนข้อสอบเติมคำ"></div></div>';
    document.getElementById('setupexamform').appendChild(div);    
  }

  var prefix1 = 'numProbC'; // number of problem with choices ans
  var prefix2 = 'numProbD'; // number of problem witn describtive ans
  var createPressed = 0;
  var existProbNum = 0;
  function createTagField() {
    // For see how many time the button is pressed
    createPressed += 1;
    // document.getElementById("createPressed").innerHTML = createPressed;
    var probnum = 0; 
    if (createPressed>1) { //to clear old tags field
      for (i=1; i<=existProbNum; i++){
        document.getElementById('tag'+parseInt(i)).remove();
      }
      existProbNum = 0;
    }
    for (i=1; i<=addSectionPressed; i++){
      probnum += parseInt(document.getElementById(prefix1+i).value)+parseInt(document.getElementById(prefix2+i).value)
    }
    document.getElementById("probnum").innerHTML = probnum;

    for (i=1; i<=probnum; i++){
      var div = document.createElement('div');
      div.innerHTML = '<div class="form-row" id="tag'+i+'"'+'><div class="col-lg-1"><p>' +i+ '</p></div><div class="col-lg-11"><input type="text" class="form-control" placeholder="tags"><br></div></div>'
      document.getElementById('tagPanel').appendChild(div);
      existProbNum +=1;
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
                        <h4 class="card-title">กำหนด Template ข้อสอบ Mockup</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="iq-card-body">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label>รายวิชา</label>
                                <select class="form-control form-control-sm mb-3">
                                    <option selected="">เลือกรายวิชา</option>
                                    <option selected="none">เลือกวิชา</option>
                                    <option value="math">คณิตศาสตร์</option>
                                    <option value="sci">วิทยาศาสตร์</option>
                                    <option value="physic">ฟิสิกส์</option>
                                    <option value="chem">เคมี</option>
                                    <option value="bio">ชีวะวิทยา</option>
                                    <option value="eng">ภาษาอังกฤษ</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>ชื่อข้อสอบ</label>
                                <select class="form-control form-control-sm mb-3">
                                    <option selected="">เลือกชื่อข้อสอบ</option>
                                    <option selected="none">เลือกชื่อข้อสอบ</option>
                                    <option value="pat">PAT</option>
                                    <option value="gat">GAT</option>
                                    <option value="onet">ONET</option>
                                    <option value="saman">9 วิชาสามัญ</option>
                                </select>
                            </div>
                        </div>
                        <div id="setupexamform">
                          <div class="form-group row">
                              <div class="col-lg-4">
                                <label>ข้อสอบตัวเลือก</label>
                                <input type="text" id='numProbC1' class="form-control" placeholder="จำนวนข้อสอบตัวเลือก">
                              </div>
                              <div class="col-lg-4">
                                <label> <br></label>
                                <input type="text" id='numC1' class="form-control" placeholder="จำนวนตัวเลือก">
                              </div>
                              <div class="col-lg-4">
                                <label>ข้อสอบเติมคำ</label>
                                <input type="text" id='numProbD1' class="form-control" placeholder="จำนวนข้อสอบเติมคำ">
                              </div>
                          </div>
                        </div>

                        <div class="form-row-center">
                          <button type="button" class="btn mb-3 btn-primary" id="addSection" onClick="addSection()">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Section</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onClick="createTagField()">Create</button>
                </div>
              </div> 
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">ใส่ Tags เพื่อกำหนด Template ข้อสอบ Mockup</h4> 
                    </div>
                    Section: <a id="sectionshow">1</a> &nbsp; จำนวนข้อ: <a id="probnum"></a> <!-- &nbsp; Create Pressed: <a id="createPressed"></a> -->
                </div>
                  <div class="card-body text-primary">
                      <div id="tagPanel">
                        <!-- for tags field input -->
                      </div>  
                      <br>
                      <div class="form-row-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                           <button type="button" class="btn btn-primary">Save</button>
                           <button type="button" class="btn btn-primary">Submit</button>
                           <button type="button" class="btn btn-primary">Cancel</button>
                           <button type="button" class="btn btn-primary">Delete</button>
                        </div>
                      </div>
                  </div>
               </div>
            </div>
          </div>
       </div>
    </div>
 </div>

&nbsp;


 <!-- Wrapper END -->
 <!-- Footer -->

@endsection
