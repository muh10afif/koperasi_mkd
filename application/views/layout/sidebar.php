<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?= base_url('home');?>" class="brand-link">
		<!-- <img src="<?php echo base_url();?>assets/logo/mui.png" alt="MUI"
			class="brand-image img-circle elevation-3" style="opacity: .8"> -->
			<!-- <img src="http://<?= $_SERVER['HTTP_HOST'] ;?>/MUI_api/documents/profile_picture/<?= $this->session->userdata('foto_user'); ?>" alt="MUI"
			class="brand-image img-circle elevation-3" style="opacity: .8"> -->
			<center><h3>MKD</h3></center>
		<!-- <span class="brand-text font-weight-light"><b>MUI</b></span> -->
		
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
			<img src="<?= base_url() ?>assets/img/user.png" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
			
			<a href="#" class="d-block"><?= ($this->session->userdata('nama') == '') ? 'A D M I N' : $this->session->userdata('nama'); ?></a>
			</div>
		</div>
		
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

				<?php $judul1 = 0; if (!empty($judul)) { $judul1 = $judul; } else { $judul1 = '0';} ?>

				<li class="nav-item">
					<a href="<?php echo base_url('home'); ?>" class="nav-link <?= ($judul1 == 'home') ? 'active' : '' ?>">
						<i class="nav-icon fa fa-home"></i>
						<p>
							Beranda
						</p>
					</a>
				</li>

				<?php if($this->session->userdata('level') == "admin")
					{
				?>
					<li class="nav-item has-treeview <?= ($judul1 == 'umkm' || $judul1 == 'pegawai' || $judul1 == 'user') ? 'menu-open' : '' ?>">
						<a href="#" class="nav-link <?= ($judul1 == 'umkm' || $judul1 == 'pegawai' || $judul1 == 'user') ? 'active' : '' ?>">
						<i class="nav-icon fa fa-server"></i>
						<p>
							Master Data
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('umkm/tambah')?>" class="nav-link <?= ($judul1 == 'umkm') ? 'active' : '' ?>">
								<i class="fa fa-dot-circle-o nav-icon"></i>
								<p>UMKM</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?php echo base_url('pegawai/tambah');?>" class="nav-link <?= ($judul1 == 'pegawai') ? 'active' : '' ?>">
								<i class="fa fa-dot-circle-o nav-icon"></i>
								<p>Pegawai</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?php echo base_url('pengguna/tambah_user');?>" class="nav-link <?= ($judul1 == 'user') ? 'active' : '' ?>">
								<i class="fa fa-dot-circle-o nav-icon"></i>
								<p>User</p>
							</a>
						</li>
						
					</ul>
				</li>

				<li class="nav-item">
					<a href="<?php echo base_url('penempatan'); ?>" class="nav-link <?= ($judul1 == 'penempatan') ? 'active' : '' ?>">
						<i class="nav-icon fa fa-street-view"></i>
						<p>
							Penempatan
						</p>
					</a>
				</li>

				<li class="nav-item has-treeview <?= ($judul1 == 'pemasukan' || $judul1 == 'pengeluaran' || $judul1 == 'saldo') ? 'menu-open' : '' ?>">
					<a href="#" class="nav-link <?= ($judul1 == 'pemasukan' || $judul1 == 'pengeluaran' || $judul1 == 'saldo') ? 'active' : '' ?>">
						<i class="nav-icon fa fa-table"></i>
						<p>
							Transaksi
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('pemasukan')?>" class="nav-link <?= ($judul1 == 'pemasukan') ? 'active' : '' ?>">
								<i class="fa fa-dot-circle-o nav-icon"></i>
								<p>Pemasukan</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?php echo base_url('pengeluaran');?>" class="nav-link <?= ($judul1 == 'pengeluaran') ? 'active' : '' ?>">
								<i class="fa fa-dot-circle-o nav-icon"></i>
								<p>Pengeluaran</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?php echo base_url('saldo');?>" class="nav-link <?= ($judul1 == 'saldo') ? 'active' : '' ?>">
								<i class="fa fa-dot-circle-o nav-icon"></i>
								<p>Saldo</p>
							</a>
						</li>
						
					</ul>
				</li>

				<li class="nav-item">
					<a href="<?php echo base_url('summary'); ?>" class="nav-link <?= ($judul1 == 'summary') ? 'active' : '' ?>">
						<i class="nav-icon fa fa-file-text"></i>
						<p>
							Summary
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="<?php echo base_url('report'); ?>" class="nav-link <?= ($judul1 == 'report') ? 'active' : '' ?>">
						<i class="nav-icon fa fa-file-o"></i>
						<p>
							Report
						</p>
					</a>
				</li>

				<?php 
					}
				?>


				<?php if($this->session->userdata('umkm') != "")
					{
				?>
						<li class="nav-item has-treeview <?= ($judul1 == 'pemasukan' || $judul1 == 'pengeluaran' || $judul1 == 'saldo') ? 'menu-open' : '' ?>">
							<a href="#" class="nav-link <?= ($judul1 == 'pemasukan' || $judul1 == 'pengeluaran' || $judul1 == 'saldo') ? 'active' : '' ?>">
								<i class="nav-icon fa fa-table"></i>
								<p>
									Transaksi
									<i class="right fa fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?php echo base_url('pemasukan/pemasukan_umkm')?>" class="nav-link <?= ($judul1 == 'pemasukan') ? 'active' : '' ?>">
										<i class="fa fa-dot-circle-o nav-icon"></i>
										<p>Pemasukan</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url('pengeluaran/pengeluaran_umkm');?>" class="nav-link <?= ($judul1 == 'pengeluaran') ? 'active' : '' ?>">
										<i class="fa fa-dot-circle-o nav-icon"></i>
										<p>Pengeluaran</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="<?php echo base_url('saldo/saldo_umkm');?>" class="nav-link <?= ($judul1 == 'saldo') ? 'active' : '' ?>">
										<i class="fa fa-dot-circle-o nav-icon"></i>
										<p>Saldo</p>
									</a>
								</li>
								
							</ul>
						</li>

						<li class="nav-item">
							<a href="<?php echo base_url('summary/summary_umkm'); ?>" class="nav-link <?= ($judul1 == 'summary') ? 'active' : '' ?>">
								<i class="nav-icon fa fa-file-text"></i>
								<p>
									Summary
								</p>
							</a>
						</li>
				<?php 
					}
				?>
				

				
			</ul> 
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
