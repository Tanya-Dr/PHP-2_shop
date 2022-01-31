<?php
class M_Product{
    public function showProduct($id,$countView=false){
        $sql = "SELECT countView FROM goods WHERE id=$id";
        $resCount = M_DB::getInstance() -> Select($sql);
        if($countView){
            $object = ['countView' => $resCount[0]['countView'] + 1];
            $where = "id=$id";
            $changedRow = M_DB::getInstance() -> Update('goods', $object, $where);
        }        
        $sql = "SELECT * FROM goods WHERE id=$id";
        $res = M_DB::getInstance() -> Select($sql);         
        return $res[0];
    }

    public function resizePhoto($file, $pathSmallPhoto){ 
        $info = getimagesize($file);
        // Ограничение по ширине в пикселях
        $max_width_size = 200;
        $max_height_size = 233;
        // Cоздаём исходное изображение на основе исходного файла
        if ($info['mime'] == 'image/jpeg')
            $source = imagecreatefromjpeg($file);
        elseif ($info['mime'] == 'image/png')
            $source = imagecreatefrompng($file);
        elseif ($info['mime'] == 'image/gif')
            $source = imagecreatefromgif($file);
        else
            return false;
    
        // Определяем ширину и высоту изображения
        $w_src = imagesx($source); 
        $h_src = imagesy($source);
    
        //  Если большое изображение устанавливаем ограничение по ширине.
        $w = $max_width_size;
    
        // Если ширина больше заданной
        if ($w_src > $w)
        {
            // Вычисление пропорций
            $ratio = $w_src/$w;
            $w_dest = @round($w_src/$ratio);
            $h_dest = min(@round($h_src/$ratio),$max_height_size);
    
            // Создаём пустую картинку
            $dest = @imagecreatetruecolor($w_dest, $h_dest);
    
            // Копируем старое изображение в новое с изменением параметров
            @imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
    
            // Вывод картинки и очистка памяти
            @imagejpeg($dest, $pathSmallPhoto, 90);
    
            @imagedestroy($dest);
            @imagedestroy($source);
    
            return $pathSmallPhoto;
    
        } else {
            // Вывод картинки и очистка памяти
            @imagejpeg($source, $pathSmallPhoto, 90);
            @imagedestroy($source);
    
            return $pathSmallPhoto;
        }
    }

    // $info = ['title' => $title,'price' => $price,'shortInfo' => $shortInfo,'fullInfo' => $fullInfo,'img' => $img,];
    public function editProduct($id,$info,$size,$photoTmpName){
        if($size == 0){
            unset($info['img']);
        }
        $where = "id=$id";
        $resUpdate = M_DB::getInstance() -> Update('goods', $info, $where);

        if($resUpdate && $size != 0){
            $pathSmallPhoto = __DIR__ . '/../' .PATH_TO_SMALL_PHOTO."/".$info['img'];
            $pathBigPhoto = __DIR__ . '/../' .PATH_TO_BIG_PHOTO."/".$info['img'];
            if($this->resizePhoto($photoTmpName,$pathSmallPhoto) && move_uploaded_file($photoTmpName,$pathBigPhoto)){
                return $id;
            }
            return "error with file";
        }elseif($resUpdate){
            return "Goods updated successfully";
        }

        return "error with editing product";
    }

    // $info = ['title' => $title,'price' => $price,'shortInfo' => $shortInfo,'fullInfo' => $fullInfo,'img' => $img,];
    public function addProduct($info,$size,$photoTmpName){
        $resInsert = M_DB::getInstance() -> Insert('goods', $info);

        if($resInsert && $size != 0){
            $pathSmallPhoto = __DIR__ . '/../' .PATH_TO_SMALL_PHOTO."/".$info['img'];
            $pathBigPhoto = __DIR__ . '/../' .PATH_TO_BIG_PHOTO."/".$info['img'];
            if($this->resizePhoto($photoTmpName,$pathSmallPhoto) && move_uploaded_file($photoTmpName,$pathBigPhoto)){
                return $resInsert;
            }
            return "error with file";
        }elseif($resInsert){
            return $resInsert;
        }

        return "error with adding product";
    }

    public function deleteProduct($id){
        $sql = "SELECT * FROM goods WHERE id=$id";
        $res = M_DB::getInstance() -> Select($sql);
        $img = $res[0]['img'];

        $pathSmallPhoto = __DIR__ . '/../' .PATH_TO_SMALL_PHOTO."/".$img;
        $pathBigPhoto = __DIR__ . '/../' .PATH_TO_BIG_PHOTO."/".$img;

        $where = "id=$id";
        $res = M_DB::getInstance() -> Delete('goods', $where);

        if($res){
            if(unlink($pathSmallPhoto) && unlink($pathBigPhoto)){
                return "Goods deleted successfully";
            }
        }
        return "error";
    }
}