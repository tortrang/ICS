<?
class pic {
	var $arr;
	var $pname;
	var $ptype;
	var $ptype2;
	var $ptmp_name;
	var $perror;
	var $psize;
	var $ppic;
	var $ppath;
	var $pwidth;
	var $pheight;
	var $r;

	function addfile($file) {
		//เก็บข้อมูลไฟล์ ในกรณีที่มีรูปภาพอยู่แล้ว
		//file ที่อยู่ไฟล์รูปภาพ
		//$p->addfile("../images/pic.jpg");
		
		$this->ppic=$file;
		$this->chktypepic();
		$this->chkpathpic();
		$this->chkdimensions();
	}
	function addpic($file) {
		//เก็บข้อมูลรูปภาพ ในกรณีที่ upload รูปภาพเข้าไปใหม่
		//file array รูปภาพที่อัพโหลด
		//$p->addpic($_FILES['pic']);
		
		$this->arr=$file;
		$this->r=$file;
		$this->proppic();
		$this->chkdimensions();
	}
	function chktypepic() { //ตรวจสอบนามสกุลไฟล์
		if($this->arr<>"") {
			$chkfile=$this->pname;
		} else {
			$chkfile=$this->ppic;
		}
		
		$strLen=strlen($chkfile);
		$index=0;
		$chkDot=true;
		for($i=1;$i<$strLen && $chkDot;$i++) {
			if($chkfile[$strLen-$i]==".") {
				$chkDot=false;
			} else {
				$index++;
			}
		}
		$this->ptype2=substr($chkfile,-$index);
		$this->r=$this->ptype2;
	}
	function chkpathpic() { //หาที่อยู่ของรูปภาพ
		if($this->arr<>"") {
		} else {
			$chkslash=explode("/",$this->ppic);
			$countchkslash=count($chkslash);
			$chkpath="";
			
			for($i=0;$i<$countchkslash-1;$i++) {
				$chkpath.=$chkslash[$i]."/";
			}
			$this->ppath=$chkpath;
		}
		$this->r=$this->ppath;
	}
	function chkdimensions() {
		if($this->arr<>"") {
			$wh=getimagesize($this->ptmp_name);
		} else {
			$wh=getimagesize($this->ppic);
		}
		$pwidth=$wh[0];
		$pheight=$wh[1];
		$this->r=array($pwidth,$pheight);
	}
	function proppic() {
		//ตรวจสอบคุณสมบัติรูปภาพ ชื่อ,ประเภท,ชื่อไฟล์,error,ขนาดไฟล์
		
		$myFile=$this->arr;
		$this->pname=$myFile['name'];#FileName
		$this->ptype=$myFile['type'];#FileType
		$this->ptmp_name=$myFile['tmp_name'];#Temp FileName
		$this->perror=$myFile['error'];#Check Error
		$this->psize=$myFile['size'];#FileSize
		
		if(!$myFile['error']) {
			$this->chktypepic();
		} else {
			die("this pic error!");
		}
	}
	function namepic() { //return ชื่อรูปภาพ
		$this->r=$this->pname;
	}
	function typepic() { //return ประเภทรูปภาพ
		$this->r=$this->ptype2;
	}
	function tmp_namepic() { //return ชื่อรูปภาพ
		$this->r=$this->ptmp_name;
	}
	function errorpic() { //return error
		$this->r=$this->perror;
	}
	function sizepic() { //return ขนาดไฟล์
		$this->r=$this->psize;
	}
	function savepic($path,$filename) {
		//เก็บรูปภาพ
		//path ที่อยู่สำหรับเก็บรูปภาพ
		//filename ชื่อรูปภาพ
		//$p->savepic("../images/","newpic");
		
		if($path[strlen($path)-1]<>"/") { $path=$path."/"; }
		
		$tmp=$this->ptmp_name;
		$new=$path . $filename . "." . $this->ptype2;
		$this->ppic=$new;
		$this->ppath=$path;
		
		if(copy($tmp,$new)) {
			$this->r="copy this pic complete.";
		} else {
			die("cannot copy this pic!");
		}
	}
	function chkscalebeforeresize($width,$height,$photoX,$photoY) {
		//check scale รูปภาพต้นฉบับก่อน resize รูปภาพ เพื่อกำหนดว่าจะอิง width หรือ height เป็นหลัก
		if(strtolower($width)=="auto" && strtolower($height)=="auto") {
			die("width and height is auto");
		}
		
		if(strtolower($width)=="auto" || strtolower($height)=="auto") {
			//die($photoX.','.$photoY);
			if(strtolower($width)=="auto") {
				$chkscale=true;
			} else {
				$chkscale=false;
			}
		} else {
			if($width>=$height) {
				$scaleRe=($width/$height)*100;
				$scaleOri=($photoX/$photoY)*100;
				
				if($scaleOri>$scaleRe) {
					$chkscale=true;
				} else {
					$chkscale=false;
				}
			} else {
				$scaleRe=($height/$width)*100;
				$scaleOri=($photoY/$photoX)*100;
				
				if($scaleOri>$scaleRe) {
					$chkscale=false;
				} else {
					$chkscale=true;
				}
			}
		}
		
		if($chkscale){
			$height1=$height;
			$width1=round($height1*$photoX/$photoY);
		} else {
			$width1=$width;
			$height1=round($width1*$photoY/$photoX);
		}
		
		return array($width1,$height1);
	}
	function chkpointforcrop($ImageType,$Path,$width,$height,$pointX,$pointY) {
		//หาจุด x,y สำหรับเริ่ม crop รูปภาพ
		if(trim(strtoupper($ImageType))=="JPG" || trim(strtoupper($ImageType))=="JPEG"){
			$chkP=imagecreatefromjpeg($Path);
		} else if(trim(strtoupper($ImageType))=='GIF'){
			$chkP=imagecreatefromgif($Path);
		} else if(trim(strtoupper($ImageType))=='PNG'){
			$chkP=imagecreatefrompng($Path);
		}
		
		$chkNewSizeW=imagesx($chkP);
		$chkNewSizeH=imagesy($chkP);
		if($pointX=="center") {
			if($chkNewSizeW>$width) {
				$halfNewPointX=$chkNewSizeW/2;
				$halfPointX=$width/2;
				$pointCropX=round($halfNewPointX-$halfPointX);
			} else {
				$pointCropX=0;
			}
		} else if($pointX=="left") {
			$pointCropX=0;
		} else if($pointX=="right") {
			if($chkNewSizeW>$width) {
				$pointCropX=$chkNewSizeW-($width+1);
			} else {
				$pointCropX=0;
			}
		} else {
			die("error pointX");
		}
		
		if($pointY=="top") {
			$pointCropY=0;
		} else if($pointY=="middle") {
			if($chkNewSizeH>$height) {
				$halfNewPointY=$chkNewSizeH/2;
				$halfPointY=$height/2;
				$pointCropY=round($halfNewPointY-$halfPointY);
			} else {
				$pointCropY=0;
			}
		} else if($pointY=="bottom") {
			if($chkNewSizeH>$height) {
				$pointCropY=$chkNewSizeH-($height+1);
			} else {
				$pointCropY=0;
			}
		} else {
			die("error pointY");
		}
		
		return array($pointCropX,$pointCropY);
	}
	function resizepic($width,$height,$filename,$path="{old}",$pointX="center",$pointY="top") {
		//resize รูปภาพ
		//width ความกว้างรูปภาพใหม่ *ถ้าจะไล่ตาม scale height ให้ใส่ค่า auto
		//height ความสูงรูปภาพใหม่ *ถ้าจะไล่ตาม scale width ให้ใส่ค่า auto
		//filename ชื่อรูปภาพใหม่
		//Path ที่อยู่ของรูปภาพใหม่  *ในกรณีที่ใช้ที่อยู่เดิมก็ไม่ต้องใส่
		//pointX เช็คจุดที่จะ crop รูป แกน X :: left, center, right
		//pointY เช็คจุดที่จะ crop รูป แกน Y :: top, middle, bottom
		//$p->resizepic(100,100,"resizepic","../img/");
		
		if($path=="{old}") {
			$path=$this->ppath;
		} else {
			if($path[strlen($path)-1]<>"/") {
				$path.="/";
			}
		}
				
		$ImageType=$this->ptype2;
		$Image=$this->ppic;
		$Path=$path . $filename . "." . $ImageType;
	
		if(trim(strtoupper($ImageType))=="JPG" || trim(strtoupper($ImageType))=="JPEG"){
		
			//create jpg
			$images_orig=imagecreatefromjpeg($Image);
			$photoX=imagesx($images_orig);
			$photoY=imagesy($images_orig);
			
			//check scale before resize
			$chkscale=$this->chkscalebeforeresize($width,$height,$photoX,$photoY);
			$width1=$chkscale[0];
			$height1=$chkscale[1];
			//check scale before resize
			
			$images_fin=imagecreatetruecolor($width1,$height1);
			imagecopyresampled($images_fin,$images_orig,0,0,0,0,$width1+1,$height1+1,$photoX,$photoY);
			imagejpeg($images_fin,$Path,100);// new filename *100=Quality
			
			//check point for crop
			$chkP=$this->chkpointforcrop($ImageType,$Path,$width,$height,$pointX,$pointY);
			$pointCropX=$chkP[0];
			$pointCropY=$chkP[1];
			//check point for crop
			
			if($width<>"auto" && $height<>"auto") {
				$image_file=$Path;
				$src_img1=imagecreatefromjpeg($image_file);
				$dst_img1=imagecreatetruecolor($width,$height) or die("<h1>Cannot create image</h1>");
				imagecopy($dst_img1,$src_img1,0,0,$pointCropX,$pointCropY,$width,$height);
				imagejpeg($dst_img1,$Path,100);// new filename *100=Quality
				imagedestroy($dst_img1);
			}
		
		} else if(trim(strtoupper($ImageType))=='GIF'){
		
			$images_orig=imagecreatefromgif($Image);
			$photoX=imagesx($images_orig);
			$photoY=imagesy($images_orig);
			
			//check scale before resize
			$chkscale=$this->chkscalebeforeresize($width,$height,$photoX,$photoY);
			$width1=$chkscale[0];
			$height1=$chkscale[1];
			//check scale before resize
			
			$images_fin=imagecreatetruecolor($width1,$height1);
			imagecopyresampled($images_fin,$images_orig,0,0,0,0,$width1+1,$height1+1,$photoX,$photoY);
			imagegif($images_fin,$Path);// new filename
			
			//check point for crop
			$chkP=$this->chkpointforcrop($ImageType,$Path,$width,$height,$pointX,$pointY);
			$pointCropX=$chkP[0];
			$pointCropY=$chkP[1];
			//check point for crop
			
			if($width<>"auto" && $height<>"auto") {
				$image_file=$Path;
				$src_img1=imagecreatefromgif($image_file);
				$dst_img1=imagecreatetruecolor($width,$height) or die("<h1>Cannot create image</h1>");
				imagecopy($dst_img1,$src_img1,0,0,$pointCropX,$pointCropY,$width,$height);
				imagegif($dst_img1,$Path);// new filename
				imagedestroy($dst_img1);
			}
		
		} else if(trim(strtoupper($ImageType))=='PNG'){
		
			$images_orig=imagecreatefrompng($Image);
			$photoX=imagesx($images_orig);
			$photoY=imagesy($images_orig);
			
			//check scale before resize
			$chkscale=$this->chkscalebeforeresize($width,$height,$photoX,$photoY);
			$width1=$chkscale[0];
			$height1=$chkscale[1];
			//check scale before resize
			
			$images_fin=imagecreatetruecolor($width1,$height1);
			imagecopyresampled($images_fin,$images_orig,0,0,0,0,$width1+1,$height1+1,$photoX,$photoY);
			imagepng($images_fin,$Path,9);// new filename *9=Quality
			
			//check point for crop
			$chkP=$this->chkpointforcrop($ImageType,$Path,$width,$height,$pointX,$pointY);
			$pointCropX=$chkP[0];
			$pointCropY=$chkP[1];
			//check point for crop
			
			if($width<>"auto" && $height<>"auto") {
				$image_file=$Path;
				$src_img1=imagecreatefrompng($image_file);
				$dst_img1=imagecreatetruecolor($width,$height) or die("<h1>Cannot create image</h1>");
				imagecopy($dst_img1,$src_img1,0,0,$pointCropX,$pointCropY,$width,$height);
				imagepng($dst_img1,$Path,9);// new filename *9=Quality
				imagedestroy($dst_img1);
			}
			
		}
		
		if(file_exists($Path)) {
			$this->r="resize this pic complete.";
		} else {
			die("cannot resize this pic!<br />[$Path]");
		}
	}
	function delpic() { //ลบรูปภาพก่อน resize
		if(unlink($this->ppic)) {
			$this->r="delete this pic complete.";
		} else {
			die("cannot delete this pic!");
		}
	}
	function ret() { //return รายละเอียด
		return $this->r;
	}
}
?>