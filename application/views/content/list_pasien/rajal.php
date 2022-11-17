<style>
#window{
    width:500px;
    border:solid 1px;
}

#title_bar{
    background: #FEFEFE;
    height: 25px;
    width: 100%;
}
#button{
    border:solid 1px;
    width: 25px;
    height: 23px;
    float:right;
    cursor:pointer;
}
#box{
    height: 150px;
    background: #DFDFDF;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom" id="tab-irj">
            <div class="tab-content">
                <div class="tab-pane active row" id="list_trn">
                    <!-- <div class="col-xs-12 col-sm-12">
                        <div id="window">
                            <div id="title_bar">
                                <div style="text-align:center" id="button">-</div>
                            </div>
                            <div id="box">
                                <br>
                                <form id="formFilterListKasir">
                                    <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="col-sm-3 control-label">RM / Nama:</label>
                                        <div class="col-sm-7">
                                            <input type="text" name="rm_nama" id="rm_nama" class="form-control input-sm" value="" placeholder="RM / NAMA PASIEN">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                        <label class="col-sm-3 control-label">Dokter:</label>
                                        <div class="col-sm-7">
                                            <select name="dokter" id="dokter" class="form-control input-sm">
                                                <option value="">--= Dokter =--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-3 col-lg-3">
                                        <div class="col-sm-4">
                                            <button class="btn btn-success btn-sm" type="button" id="btnCariTable"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-xs-12 col-sm-12"><hr></div>
                    <div id="targetTable" class="col-xs-12" style="overflow:auto;">
                        <table class="table table-bordered table-hover" id="table-list-antrian">
                            <thead>
                                <tr class="success">
                                    <th style="width:5%;">No</th>
                                    <th>Tgl. Reg</th>
                                    <th>No. Reg</th>
                                    <th>No. RM</th>
                                    <th>Nama</th>
                                    <th>Nama Dokter</th>
                                    <th>Poli</th>
                                    <th>Nomor Urut</th>
                                    <th>Kategori</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var tanggal = "";
    var rm_nama = "";
    var dokter = "";
    var kdpoli = "<?=$this->session->userdata('kd_poli') ?? ''?>";
    var table = '';
    
    $(document).ready(function(){
    });
    $("#button").click(function(){
        if($(this).html() == "-"){
            $(this).html("+");
        }
        else{
            $(this).html("-");
        }
        $("#box").slideToggle();
    });

    $('#btnCariTable').click(function(){
        table.ajax.reload();
    });
    
    table = $('#table-list-antrian').DataTable({
        lengthMenu: [[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]],
        scrollX:true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        language: {
            processing: '<i class="fa fa-refresh fa-spin fa-3x fa-fw" style="color:#fff"></i><span>Mohon Tunggu...</span>'
        },
        pageLength:15,
        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?=base_url('RawatJalan/ajax_list')?>",
            type: "POST",
            data: function(send){
                send.set  = 'list-rj';
                send.tanggal  = $('#TanggalTransaksi').val();
                send.rm_nama  = $("#rm_nama").val();
                send.dokter  = $("#dokter").val();
            },
        },
        // fnDrawCallback:function(resp){
        //     // console.log(resp.json);
        //     pageTotal = resp.json.totalFromPage;
        //     dataTotal = resp.json.totalFromData;
        //     $("#pageTotal").html(pageTotal);
        //     $("#dataTotal").html(dataTotal);
        // },
        //Set column definition initialisation properties.
        columnDefs: [
            {
                targets: [ -1 ], //first column / numbering column
                orderable: false, //set not orderable
            },
        ],
    });
</script>
