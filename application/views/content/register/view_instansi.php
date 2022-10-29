<div class="row">
    <div class="col-sm-12 col-md-12">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="col-sm-12">
                <div class="col-sm-12 col-md-12">
                    <p><u>PESERTA INSTANSI</u></p>
                    <form method="post" class="row" id="form-psn-bpjs">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right"> No Registrasi</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
                                        <input type="text" name="Regno" class="form-control input-sm" id="Regno" readonly value="<?= $regno ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="display: none">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Status Rujukan</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <div class="radio">
                                            <label>
                                                <input name="StatusRujuk" type="radio" class="ace" value="0"/>
                                                <span class="lbl">&nbsp; Non Rujukan</span>
                                            </label>
                                            <label>
                                                <input name="StatusRujuk" type="radio" class="ace" value="1" checked/>
                                                <span class="lbl">&nbsp; Faskes 1</span>
                                            </label>
                                            <label>
                                                <input name="StatusRujuk" type="radio" class="ace" value="2"/>
                                                <span class="lbl">&nbsp; Faskes 2(Rumah Sakit)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="loading_home"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <p><u>Data Pasien</u></p>
                                <!-- Nomor RM -->
                                <form method="get">
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right" > No Rekam Medis</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
                                        <input type="text" name="Medrec" id="Medrec"/>
                                        <button type="submit" class="btn btn-info btn-sm" id="btnCari" style="margin-left: 10px;">
                                            <i class="ace-icon fa fa-search"></i>Cari
                                        </button>
                                    </div>
                                </div>
                                </form>
                                <!-- Nama Pasien -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:transparent;">:</span>
                                        <input type="text" name="Firstname" id="Firstname" class="form-control input-sm col-xs-10 col-sm-5"/>
                                    </div>
                                </div>
                                <!-- No Peserta BPJS -->
                                <form method="get" id="search_no_peserta">
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right"> No Peserta BPJS</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="noKartu" class="form-control input-sm" id="noKartu"/>
                                        <!-- Tgl Daftar -->
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Daftar</span>
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="TglDaftar" id="TglDaftar" class="form-control input-sm col-xs-6 col-sm-6" readonly/>
                                    </div>
                                </div>
                                </form>
                                <!-- Tanggal Daftar -->
                                <form method="get" id="search_nik">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">NIK KTP</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="NoIden" class="form-control input-sm" id="NoIden"/>
                                        <!-- Tanggal Registrasi -->
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Registrasi</span>
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="Regdate" id="Regdate" class="form-control input-sm col-xs-6 col-sm-6" value="<?= date('Y-m-d') ?>"/>
                                    </div>
                                </div>
                                </form>
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right" >Instansi - Unit</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select type="text" name="instansiPasien" id="instansi" style="width:100%;" class="form-control select2 input-sm">
                                            <option value="">-= Instansi =-</option>
                                            <?php foreach ($instansi as $row):?>
                                                <optgroup label='<?=$row->NmInstansi ?>'>
                                                    <?php foreach ($unit as $row2):?>
                                                        <?php if ($row2->KdInstansi == $row->KdInstansi): ?>
                                                            <option value="<?=$row2->KdUnit?>"><?=$row2->NmUnit?></option>
                                                        <?php endif ?>
                                                    <?php endforeach?>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                </div>
                                <!-- No Rujukan -->
                                <form method="get" id="search_noRujukan">
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">No Rujukan</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="NoRujuk" class="form-control input-sm" id="NoRujuk"/>
                                        <!-- Jam Registrasi -->
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Jam Registrasi</span>
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="time" name="Regtime" id="Regtime" class="form-control input-sm col-xs-6 col-sm-6" value="<?= date('H:i') ?>"/>
                                    </div>
                                </div>
                                </form>
                                <!-- No Surat Kontrol -->
                                <form method="get" id="search_nosurat">
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">No Surat Kontrol</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="NoSuratKontrol" class="form-control input-sm" id="NoSuratKontrol"/>
                                        <!-- Tanggal Registrasi -->
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Tgl Rujukan</span>
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="RegRujuk" id="RegRujuk" class="form-control input-sm col-xs-6 col-sm-6" value="<?= date('Y-m-d') ?>"/>
                                    </div>
                                </div>
                                </form>
                                <div class="form-group" style="display: none;">
                                    <label class="col-md-3 control-label no-padding-right">Dokter Pengirim/DPJP</label>
                                    <div class="input-group col-md-9">
                                        <span class="input-group-addon" id="" style="border:none; background-color: transparent;">:</span>
                                        <select name="DokterPengirim" id="DokterPengirim" style="width:100%;" class="form-control input-sm select2" readonly="readonly">
                                            <!-- <option value="{{ isset($edit->KdDPJP) ? $edit->KdDPJP : '' }}">{{ isset($edit->KdDPJP : '-= Dokter Pengirim =-' }}</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <p><u>Status Pasien</u></p>
                                <!-- Tanggal Lahir -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Tgl Lahir</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="date" name="Bod" id="Bod" class="form-control input-sm col-xs-6 col-sm-6" />
                                        <!-- Input Umur -->
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">Umur (t/b/h)</span>
                                        <!-- Input Umur Tahun -->
                                        <input type="text" name="UmurThn" id="UmurThn" class="form-control input-sm col-xs-6 col-sm-3" readonly/>
                                        <!-- Input Umur Bulan -->
                                        <span class="input-group-addon no-border-right no-border-left" id="">/</span>
                                        <input type="text" name="UmurBln" id="UmurBln" class="form-control input-sm col-xs-6 col-sm-3" readonly/>
                                        <!-- Input Umur Hari -->
                                        <span class="input-group-addon no-border-right no-border-left" id="">/</span>
                                        <input type="text" name="UmurHari" id="UmurHari" class="form-control input-sm col-xs-6 col-sm-3" readonly/>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">No. Urut</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="NomorUrut" id="NomorUrut" readonly="readonly">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white; display: none;">Kunjungan</span>
                                        <select type="text" name="Kunjungan" id="Kunjungan" style="width:100%;" class="form-control" >
                                            <option value="">-= Kunjungan =-</option>
                                            <option value="Lama">Lama</option>
                                            <option value="Baru">Baru</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Jenis Kelmin -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Jenis Kelamin</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <div class="radio">
                                            <label>
                                                <input name="KdSex" type="radio" class="ace" value="L"/>
                                                <span class="lbl">&nbsp; Laki - Laki</span>
                                            </label>
                                            <label>
                                                <input name="KdSex" type="radio" class="ace" value="P"/>
                                                <span class="lbl">&nbsp; Perempuan</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Kategori Pasien -->
                                <div class="form-group" style="display: none">
                                    <label class="col-sm-3 control-label no-padding-right">Kategori Pasien</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select type="text" name="KategoriPasien" id="Kategori" style="width:50%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                            <option value="1">UMUM</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- No Telepon -->
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">No Telepon</label>
                                        <div class="input-group col-sm-9">
                                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                            <input type="text" name="Notelp" id="Notelp" class="form-control input-sm col-xs-6 col-sm-6"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Jatah Kelas -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Jatah Kelas</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select type="text" name="JatKelas" id="jatah_kelas" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6">
                                            <!-- @if(isset($edit))
                                            <option value="{{ $edit->NmKelas }}">Kelas {{ $edit->NmKelas }}</option>
                                            <option value="1">Kelas 1</option>
                                            <option value="2">Kelas 2</option>
                                            <option value="3">Kelas 3</option>
                                            @else -->
                                            <option value="">-= Kelas =-</option>
                                            <option value="1">Kelas 1</option>
                                            <option value="2">Kelas 2</option>
                                            <option value="3">Kelas 3</option>
                                            <!-- @endif -->
                                        </select>
                                        <input type="hidden" name="NmKelas" id="NmKelas">
                                    </div>
                                </div>
                                <!-- PISAT -->
                                <div class="form-group" style="display: none;">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">PISAT</label>
                                        <div class="input-group col-sm-9">
                                            <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                            <input type="text" name="pisat" id="pisat" class="form-control input-sm col-xs-6 col-sm-6" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row" style="display: none;">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <p><u>Status Pengobatan</u></p>
                                <!-- Tujuan Pelayanan -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Tujuan Pelayanan</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="KdTuju" id="pengobatan" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" readonly="readonly">
                                            <option value="2">Rawat Jalan</option>
                                            <option value="PK">Penunjang Klinik</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Nama Poli / SMF -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Nama Poli / SMF</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="KdPoli" id="poli" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <option value="38" data-select2-id="14">Patologi Anatomi MICRO</option>
                                        </select>
                                        <input type="hidden" name="KdPoliBpjs">
                                    </div>
                                </div>
                                <!-- Poli Eksekutif -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Poli Eksekutif</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <div class="radio">
                                            <label>
                                                <input name="eksekutif" type="radio" class="ace" value="0" checked />
                                                <span class="lbl">&nbsp; Tidak</span>
                                            </label>
                                            <label>
                                                <input name="eksekutif" type="radio" class="ace" value="1"/>
                                                <span class="lbl">&nbsp; Ya</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Katarak -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Katarak</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <div class="radio">
                                            <label>
                                                <input name="Katarak" type="radio" class="ace" value="0" checked />
                                                <span class="lbl">&nbsp; Tidak</span>
                                            </label>
                                            <label>
                                                <input name="Katarak" type="radio" class="ace" value="1"/>
                                                <span class="lbl">&nbsp; Ya</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- COB -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">COB</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <div class="radio">
                                            <label>
                                                <input name="Cob" type="radio" class="ace" value="0" checked />
                                                <span class="lbl">&nbsp; Tidak</span>
                                            </label>
                                            <label>
                                                <input name="Cob" type="radio" class="ace" value="1"/>
                                                <span class="lbl">&nbsp; Ya</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Asal Rujukan -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Asal Rujukan</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <div class="radio">
                                            <label>
                                                <input name="Faskes" type="radio" class="ace" value="1" checked />
                                                <span class="lbl">&nbsp; Faskes 1</span>
                                            </label>
                                            <label>
                                                <input name="Faskes" type="radio" class="ace" value="2"/>
                                                <span class="lbl">&nbsp; Faskes 2</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- PPK -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">PPK</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Ppk" id="Ppk" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6">
                                            <!-- <option value="{{ isset($edit->KdRujukan) ? $edit->KdRujukan : '' }}">{{ isset($edit->NmRujukan : '-= PPK =-' }}</option> -->
                                        </select>
                                        <input type="hidden" name="noPpk" id="noPpk">
                                    </div>
                                </div>
                                <!-- Penjamin -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Penjamin</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select name="Penjamin" id="NMPenjamin" style="width:100%;" class="form-control input-sm select2 col-xs-6 col-sm-6" >
                                            <option value="">- Penjamin -</option>
                                            <option value="1">1. Jasa Raharja</option>
                                            <option value="2">2. BPJS Ketenagakerjaan</option>
                                            <option value="3">3. TASPEN</option>
                                            <option value="4">4. ASABRI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                                <p><u>Status Pembayaran</u></p>
                                <!-- Cara Bayar -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Cara Bayar</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select type="text" name="KdCbayar" id="cara_bayar" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                            <option value="01" selected>CASH</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Peserta -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Peserta</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Peserta" id="Peserta" class="form-control input-sm col-xs-10 col-sm-5" readonly/>
                                        <input type="hidden" name="kodePeserta" id="kodePeserta" class="form-control input-sm col-xs-10 col-sm-5" readonly/>
                                    </div>
                                </div>
                                <!-- Status Peserta -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Status Peserta</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="statusPeserta" id="statusPeserta" class="form-control input-sm col-xs-10 col-sm-5" readonly/>
                                    </div>
                                </div>
                                <!-- Dinsos -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Dinsos</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Dinsos" id="Dinsos" class="form-control input-sm col-xs-10 col-sm-5" readonly />
                                    </div>
                                </div>
                                <!-- No SKTM -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">No SKTM</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="NoSktm" id="NoSktm" class="form-control input-sm col-xs-10 col-sm-5" readonly />
                                    </div>
                                </div>
                                <!-- Prolanis PRB -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Prolanis PRB</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="Prolanis" id="Prolanis" class="form-control input-sm col-xs-10 col-sm-5" readonly />
                                    </div>
                                </div>
                                <!-- Diagnosa Awal -->
                                <div class="form-group" style="display: none;"> 
                                    <label class="col-sm-3 control-label no-padding-right">Diagnosa Awal</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <select type="text" name="DiagAw" id="Diagnosa" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                            <!-- @if(isset($edit) && isset($edit->KdICD)) -->
                                            <!-- <option value="{{ $edit->KdICD }}" selected="selected">{{ $edit->DIAGNOSA }}</option> -->
                                            <!-- @else -->
                                            <option value="">-= Diagnosa =-</option>
                                            <!-- @endif -->
                                        </select>
                                    </div>
                                </div>
                                <!-- Catatan -->
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right">Catatan</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <textarea class="form-control input-sm col-xs-10 col-sm-5" name="catatan" id="catatan">Patologi Anatomi</textarea>
                                    </div>
                                </div>
                                <!-- No SEP -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">No SEP</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="NoSep" id="NoSep" class="col-xs-6"/>
                                        <button type="button" class="btn btn-success" id="createsep" style="margin-left: 10px;">
                                            <i class="ace-icon fa fa-plus"></i>Create SEP
                                        </button>
                                    </div>
                                </div>
                                <!-- Notifikasi SEP -->
                                <div class="form-group" style="display: none;">
                                    <label class="col-sm-3 control-label no-padding-right">Notifikasi SEP</label>
                                    <div class="input-group col-sm-9">
                                        <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                        <input type="text" name="NotifSep" id="NotifSep" class="form-control input-sm col-xs-10 col-sm-5"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
                        <input type="hidden" name="change_keyakinan" id="change_keyakinan">
                        <input type="hidden" name="regold" id="regold">
                        <button type="submit" name="submit" id="submit" class="btn btn-success">Simpan</button>
                        <!-- <button type="button" name="printsep" id="printsep" class="btn btn-primary"><i class="fa fa-print"></i> Print SEP</button> -->
                        <a href="" class="btn btn-warning"><i class="fa fa-check"></i> Baru</a>
                        <!-- <button type="button" name="printslip" id="printslip" class="btn btn-primary hidden"><i class="fa fa-print"></i> Print Slip</button> -->
                        <button type="button" name="printlabel" id="printlabel" class="btn btn-primary hidden"><i class="fa fa-print"></i> Print Label</button>
                        <!-- <button type="button" name="printkeyakinan" id="printkeyakinan" class="btn btn-primary hidden"><i class="fa fa-print"></i> Print Keyakinan</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL CARI PASIEN -->
    <div class="modal fade bd-example-modal-lg-caripasien"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title" id="exampleModalLabel">Cari Data Pasien</h5>
                    </div><hr>
                    <form method="get" id="bd-example-modal-lg-caripasien">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Rekam Medis</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Medrec" id="pa_Medrec" class="form-control input-sm col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Phone</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Phone" id="pa_Phone" class="form-control input-sm col-xs-10 col-sm-5" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Firstname" id="pa_Firstname" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Alamat</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_Address" id="pa_Address" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">No BPJS</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="text" name="pa_noPeserta" id="pa_noPeserta" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Tanggal Lahir</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="date" name="pa_Tgl_lahir" id="pa_Tgl_lahir" class="form-control input-sm col-xs-10 col-sm-5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right">Tanggal Daftar</label>
                                <div class="input-group col-sm-9">
                                    <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                    <input type="date" name="date1" id="date1" style="width: 40%" />
                                    <span class="" id="" style="background-color:white; margin-right: 10px;">S/D</span>
                                    <input type="date" name="date2" id="date2" style="width: 40%" />
                                </div>
                            </div>
                        </div>
                        <div class="pull-right"><button type="submit" class="btn btn-info btn-sm" name="cari_pasien"><i class="fa fa-search"></i> Cari</button></div>
                    </form>
                </div>
                <div class="modal-body">
                    <div style="overflow:auto;" id="target_cari_pasien"></div>
                </div>
            </div>
        </div>
    </div><!-- MODAL CARI PASIEN -->
    <!-- HISTORI PASIEN -->
    <div class="modal fade bd-example-modal-lg-histori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Histori Pasien <span id="nama-message"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div style="overflow:auto;" id="target_table">
                        <table class="table table-bordered" id="table-histori">
                            <thead>
                                <tr>
                                    <th>No Sep</th>
                                    <th>RI/RJ</th>
                                    <th>Poli</th>
                                    <th>Tgl SEP</th>
                                    <th>No Rujukan</th>
                                    <th>Diagnosa</th>
                                    <th>PPK Perujuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="11">Tidak ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-loading" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-loading">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="alert alert-info">Memuat Data.. <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Print -->
    <div class="modal fade" id="modalPrintSurat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Pasien</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="targetPrint"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
<!-- end Modal Print-->
    <!-- MODAL UPDATE KATEGORI -->
    <div class="modal fade bd-example-modal-lg-update-kategori" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <p><u>Data Pasien</u></p>
                        <div class="form-group">
                            <!-- No RM -->
                            <label class="col-sm-3 control-label no-padding-right">No Rekam Medis</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="kat_NoRM" id="kat_NoRM" class="form-control input-sm col-xs-6 col-sm-6" readonly  value=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Nama Pasien -->
                            <label class="col-sm-3 control-label no-padding-right">Nama Pasien</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="kat_Firstname" id="kat_Firstname" class="form-control input-sm col-xs-6 col-sm-6" readonly placeholder="Nama Pasien" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Kategori Pasien -->
                            <label class="col-sm-3 control-label no-padding-right">Kategori Pasien</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <select type="text" name="kat_Kategori" id="kat_Kategori" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                    <option value="">-= Kategori Pasien =-</option>
                                    <?php foreach ($kategori as $key => $k):?>
                                        <option value="<?=$k->KdKategori?>"><?=$k->NmKategori?></option>
                                    <?php endforeach?>
                                </select>
                                <input type="hidden" name="kat_nmKategori" id="kat_nmKategori">
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Group Unit -->
                            <label class="col-sm-3 control-label no-padding-right">Group Unit</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <select type="text" name="GroupUnit" id="GroupUnit" style="width:100%;" class="form-control select2 input-sm col-xs-6 col-sm-6">
                                    <option value="">-= GroupUnit =-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- Input Unit -->
                            <label class="col-sm-3 control-label no-padding-right">Unit</label>
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <select name="Unit" id="Unit" style="width:100%;" class="form-control input-sm col-xs-6 col-sm-6 select2">
                                    <option value="">-= Unit =-</option>
                                    <optgroup id="optUnit"></optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- No Peserta/BPJS -->
                            <label class="col-sm-3 control-label no-padding-right">No Peserta/BPJS</label>
                            <div class="input-group col-sm-3">
                                <span class="input-group-addon" id="" style="border:none;background-color:white;">:</span>
                                <input type="text" name="kat_NoPeserta" id="kat_NoPeserta" class="form-control input-sm col-xs-6 col-sm-6"/>
                            </div>
                        </div>
                        <input type="submit" name="submit" id="update_kategori" class="btn btn-success" value="Update" />
                    </form>
                </div>
            </div>
        </div>
    </div><!-- MODAL UPDATE KATEGORI -->
    <!-- MODAL PRINT -->
    <div class="modal fade" id="modalPrintSurat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Pasien</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="targetPrint"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL PRINT -->
<script>
    $(document).ready(function(){
        if ($('#Regno').val() != '') {
            search_regno($('#Regno').val());
        }
    });

    $('#GroupUnit').select2({
        placeholder:'-= Group Unit =-',
        allowClear: true,
        ajax: {
            url:"<?=base_url('api/groupunit')?>",
            type:"POST",
            dataType: 'JSON',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20,
                    kategori: $('#kat_Kategori').val()
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.GroupUnit;
                        item.text = item.GroupUnit;
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                    ${item.GroupUnit}
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });

    $('#Unit').select2({
        placeholder:'-= Unit =-',
        allowClear: true,
        ajax: {
            url:"<?=base_url('api/unit')?>",
            type:"POST",
            dataType: 'JSON',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20,
                    groupunit: $('#GroupUnit').val()
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.NmUnit;
                        item.text = item.NmUnit;
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                    ${item.NmUnit}
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });

    $('#Diagnosa').select2({
        placeholder:'-= Diagnosa =-',
        allowClear: true,
        ajax: {
            url:"<?=base_url('api/icd10')?>",
            type:"POST",
            dataType: 'JSON',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KDICD;
                        item.text = item.DIAGNOSA.trim();
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                    ${item.KDICD} - ${item.DIAGNOSA.trim()}
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });

    $('#poli').select2();

    $('#Dokter').select2({
        ajax: {
            url:"<?=base_url('api/dokter')?>",
            type:'post',
            dataType: 'json',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20,
                    kdpoli:kdPoli
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KdDoc;
                        item.text = item.NmDoc;
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                   ${item.NmDoc} - ${item.KdDPJP ? item.KdDPJP : ''} 
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });


    let kdPoli = '';
    $('#poli').on('select2:select', function(ev) {
        let data = ev.params.data;
        kdPoli = data.KdPoli;
        $('[name=KdPoliBpjs]').val(data.KdBPJS);
    });

    let KdDPJP = null;
    $('#DokterPengirim').on('select2:select', function(ev){
        KdDPJP = ev.params.data.KdDPJP;
    });

    let polirujukan = '';
    $('#DokterPengirim').select2({
        ajax: {
            url:"<?=base_url('api/dokter_pengirim')?>",
            type:'post',
            dataType: 'json',
            data: function(params) {
                return {
                    q: params.term,
                    offset: (params.page || 0) * 20
                };
            },
            processResults: function(data, params) {
                return {
                    results: data.data.map(function(item){
                        item.id = item.KdDoc;
                        item.text = item.NmDoc;
                        return item;
                    }),
                    pagination: {
                        more: data.has_next
                    }
                }
            },
        },

        templateResult: function(item) {
            if(item.loading) {
                return item.text;
            }

            return `
                <p>
                   ${item.NmDoc} - ${item.KdDPJP ? item.KdDPJP : ''} 
                </p>
            `;
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        templateSelection: function(item) {
            return item.text;
        },
    });

    const select2Bpjs = {
        ajax: { dataType: 'json', },
        templateResult: function(item) { return item.loading ? item.text : `<p>${item.text}</p>`; },
        escapeMarkup: function(markup) { return markup; },
        templateSelection: function(item) { return item.text; },
    };

    function select2VClaimResponse(data, params, success) {

        if(!params.term) {
            return {
                results: [{text: 'Silahkan ketik dahulu', loading: true}],
                pagination: {more: false}
            };
        }
        if(!data || !data.metaData) {
            return {
                results: [{text: '[ERR] Tidak ada respon dari server', loading: true}],
                pagination: {more: false}
            };
        }

        if(data.metaData.code != 200) {
            return {
                results: [{text: data.metaData.message, loading: true}],
                pagination: {more: false}
            };
        }

        return success(data, params);
    }

    $('#Ppk').select2($.extend(true, select2Bpjs, {
        ajax: {
            url: "<?=base_url('bridgingvclaim/faskes')?>",
            data: function(params) {
                return $.extend(params, { faskes: $("input[name=Faskes]:checked").val() });
            },
            processResults: function(data, params) {
                return select2VClaimResponse(data, params, function(data, params) {
                    return {
                        results: data.response.faskes.map(function(item) {
                            return $.extend(item, {
                                id: item.kode,
                                text: item.nama,
                            });
                        }),
                        pagination: {more: false},
                    };
                });
            }
        }
    }));

    $('#Ppk').on("change",function(){ 
        text = $("#Ppk option:selected").text();
        $("#noPpk").val(text);
    });

    $('#btnShowList').on('click', function(ev) {
        ev.preventDefault();
        $.ajax({
            url:"<?= base_url('registrasi/list_pasien_penunjang_klinik')?>",
            type:'POST',
            data:{
                date1: $('#datelist1').val(),
                date2: $('#datelist2').val(),
                medrec: $('#search_medrec').val(),
            },
            beforeSend:function(){
                $('#halaman').html('<div class="alert alert-info">Memuat Data <span style="text-align:right"><i class="fa fa-spinner fa-pulse"></i></span></div>');
            },
            success:function(response){
                $('#halaman').html(response);
            }
        });
    });


    let janji = null;
    $('#Perjanjian').click(function() {
        janji = $('#Perjanjian').prop('checked');
    });

    $("#submit").on("click",function(e){
        e.preventDefault();
        let loading = $('.modal-loading');
        loading.modal('show');

        var h2 = $('#Regdate').val();
        // var selisih =  Math.abs(Number(new Date(h2)) - Number(new Date())) / (60 * 24 * 24 * 1000);

        if ($('#pengobatan').val() == '') {
            alert('Pilih Tujuan!');
        } else if($('#poli').val() == '') {
            alert('Pilih Poli!');
        } else if($('#Kategori').val() == '') {
            alert('Silahkan pilih kategori atau segera update kategori');
        } else if(($('input[name=KdSex]:checked').length) <= 0 ) {
            alert('Pilih jenis kelamin Pasien');
        }else{
            $.ajax({
                url:"<?=base_url('registrasi/post_instansi')?>",
                type:"post",
                dataType:"json",
                data:{
                    Regno: $('#Regno').val(),
                    Medrec: $('#Medrec').val(),
                    Firstname: $('#Firstname').val(),
                    Regdate: $('#Regdate').val(),
                    Regtime: $('#Regtime').val(),
                    KdCbayar: $('#cara_bayar').val(),
                    Penjamin: $('[name=Penjamin]').val(),
                    noKartu: $('#noKartu').val(),
                    KdTuju: $('#pengobatan').val(),
                    KdPoli: $('#poli').val(),
                    DocRS: $('#DokterPengirim').val(),
                    Kunjungan: $('#Kunjungan').val(),
                    UmurThn: $('#UmurThn').val(),
                    UmurBln: $('#UmurBln').val(),
                    UmurHari: $('#UmurHari').val(),
                    Bod: $('#Bod').val(),
                    NomorUrut: $('#NomorUrut').val(),
                    KategoriPasien: $('#Kategori').val(),
                    NoSep: $('#NoSep').val(),
                    DiagAw: $('#Diagnosa').val(),
                    KdSex: $('input[name=KdSex]:checked').val(),
                    pisat: $('#pisat').val(),
                    GroupUnit: $('#GroupUnit').val(),
                    Keterangan: $('#Keterangan').val(),
                    NoRujuk: $('#NoRujuk').val(),
                    RegRujuk: $('#RegRujuk').val(),
                    noPpk: $('#noPpk').val(),
                    Ppk: $('#Ppk').val(),
                    kodePeserta: $('#kodePeserta').val(),
                    Peserta: $('#Peserta').val(),
                    JatKelas: $('#jatah_kelas').val(),
                    NotifSep: $('#NotifSep').val(),
                    KasKe: $('input[name=KasKe]:checked').val(),
                    NoIden: $('#NoIden').val(),
                    unitInstansi: $('#instansi').val(),
                    statusPeserta: $('#statusPeserta').val(),
                    Faskes: $('input[name=Faskes]:checked').val(),
                    Notelp: $('#Notelp').val(),
                    Cob: $('input[name=Cob]:checked').val(),
                    Keyakinan: $('#change_keyakinan').val(),
                    Prolanis: $('#Prolanis').val(),
                    Perjanjian: janji,
                    asalRujukan: $('[name=Faskes]').val(),
                    KdDPJP: $('#DokterPengirim').val(),
                    kdrujuk: $('#NoRujuk').val(),
                    nokontrol: $('#NoSuratKontrol').val(),
                    idregold: $('[name=regold]').val(),
                    catatan: $('#catatan').val()
                },beforeSend(){
                    loading.modal('show');
                },error: function(response){
                    alert('Gagal menambahkan/server down, Silahkan coba lagi');
                    loading.modal('hide');
                },
                success:function(response)
                {
                    console.log(response);
                    loading.modal('hide');
                    $('#Regno').val(response.Regno);
                    $('#NomorUrut').val(response.NomorUrut);
                    // alert('sedang dalam perbaikan 30mnt/ selain fisio terapi pasien masuk');
                    pesan = response.message + "\n" +
                            "Pasien " + response.Firstname + "\n" +
                            "Antrian aplikasi baru " + response.NomorUrut;
                    alert(pesan);
                    window.location.replace("<?=base_url('list_pasien')?>");
                    // if (response.NoSep != '') {
                    //     search_sep(response.NoSep);
                    // }
                }
            });
        }
        loading.modal('hide');
    });


    $('#kat_Kategori').on("change",function(){
        text = $("#kat_Kategori option:selected").text();
        $("#kat_nmKategori").val(text);
    });

    // Ngitung Umur
    $('#Bod').on("change",function(){
        var today = new Date();
        var bod = $('#Bod').val();
        var age = "";
        var month = Number(bod.substr(5,2));
        var day = Number(bod.substr(8,2));

        // Get Year
        age = today.getFullYear() - bod.substring(0,4);
        if (today.getMonth() < (month - 1)) {
            age--;
        }
        if (((month - 1) == today.getMonth()) && (today.getDate() < day)) {
            age--;
        }
        $('#UmurThn').val(age);

        // Get Month
        var calMonth = (today.getMonth()+1)-month;
        if ( calMonth < 0) {
            if (calMonth < 0) {
                var generateMonth = calMonth+12;
                $('#UmurBln').val(generateMonth);
            }else{
                $('#UmurBln').val(calMonth);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurBln').val(calMonth);
        }

        // Get Day
        var callDay = today.getDate()-day;
        if ( callDay < 0) {
            if (callDay < 0) {
                var generateDay = callDay+30;
                $('#UmurHari').val(generateDay);
            }else{
                $('#UmurHari').val(callDay);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurHari').val(callDay);
        }

    });

    function sum_bod(age) {
        var today = new Date();
        var bod = age;
        var age = "";
        var month = Number(bod.substr(5,2));
        var day = Number(bod.substr(8,2));

        // Get Year
        age = today.getFullYear() - bod.substring(0,4);
        if (today.getMonth() < (month - 1)) {
            age--;
        }
        if (((month - 1) == today.getMonth()) && (today.getDate() < day)) {
            age--;
        }
        $('#UmurThn').val(age);

        // Get Month
        var calMonth = (today.getMonth()+1)-month;
        if ( calMonth < 0) {
            if (calMonth < 0) {
                var generateMonth = calMonth+12;
                $('#UmurBln').val(generateMonth);
            }else{
                $('#UmurBln').val(calMonth);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurBln').val(calMonth);
        }

        // Get Day
        var callDay = today.getDate()-day;
        if ( callDay < 0) {
            if (callDay < 0) {
                var generateDay = callDay+30;
                $('#UmurHari').val(generateDay);
            }else{
                $('#UmurHari').val(callDay);
            }
        }else{
            // var valMonth = today.getMonth() - month;
            
            $('#UmurHari').val(callDay);
        }
    }

    function search_regno(regno) {
        $.ajax({
            url:"<?= base_url('registrasi/search_regno')?>",
            type:"get",
            data:{
                regno: regno,
            },
            success: function(response)
            {
                console.log(response.data);
                $('#Kunjungan').val('Lama');
                $('#Medrec').val(response.data.Medrec);
                $('#Notelp').val(response.data.phone);
                $('#kat_NoRM').val(response.data.Medrec);
                $('#kat_Firstname').val(response.data.Firstname);
                $('#Kategori').val(response.data.Kategori);
                $('#Regdate').val(response.data.Regdate.substring(0,10));
                $('#NomorUrut').val(response.data.NomorUrut);
                $('#Firstname').val(response.data.Firstname);
                $('#NoIden').val(response.data.nikktp);
                $('#pisat').val(response.data.Pisat);
                $('#noKartu').val(response.data.NoPeserta);
                $('#TglDaftar').val(response.data.Regdate.substring(0,10));
                $('#Bod').val(response.data.Bod.substring(0,10));
                sum_bod(response.data.Bod.substring(0,10));
                $('#statusPeserta').val(response.data.StatPeserta);
                $('#Peserta').val(response.data.NmRefPeserta);
                if (response.data.KdSex != null) {
                    $("input[name=KdSex][value="+response.data.KdSex.toUpperCase()+"]").attr('checked', 'checked');
                }
                $('#catatan').val(response.data.Catatan);
            }
        });
    }

</script>