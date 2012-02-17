<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * PHP MATH CAPTCHA
	 * Copyright (C) 2010  Constantin Boiangiu  (http://www.php-help.ro)
	 * 
	 * This program is free software: you can redistribute it and/or modify
	 * it under the terms of the GNU General Public License as published by
	 * the Free Software Foundation, either version 3 of the License, or
	 * (at your option) any later version.
	 * 
	 * This program is distributed in the hope that it will be useful,
	 * but WITHOUT ANY WARRANTY; without even the implied warranty of
	 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 * GNU General Public License for more details.
	 * 
	 * You should have received a copy of the GNU General Public License
	 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
	 **/

	/**
	 * @author Constantin Boiangiu
	 * @link http://www.php-help.ro
	 * 
	 * This script is provided as-is, with no guarantees.
	 */
	
	/* 
		if you set the session in some configuration or initialization file with
		session id, delete session_start and make a require('init_file.php');
	*/
class Mathcaptcha
{
	
	/*===============================================================
		General captcha settings
	  ===============================================================*/
	// captcha width
	private $captcha_w = 150;
	// captcha height
	private $captcha_h = 50;
	// minimum font size; each operation element changes size
	private $min_font_size = 12;
	// maximum font size
	private $max_font_size = 18;
	// rotation angle
	private $angle = 20;
	// background grid size
	private $bg_size = 13;
	// path to font - needed to display the operation elements
	private $font_path = '/fonts/courbd.ttf';
	// array of possible operators
	private $operators=array('+','-','*');
	private $first_num= null;
	private $second_num= null;
	
	
		
	/*===============================================================
		From here on you may leave the code intact unless you want
		or need to make it specific changes. 
	  ===============================================================*/
	
	function generate_captcha(){
		$this->CI =& get_instance();
		
		$this->first_num = rand(1,5);
		$this->second_num = rand(6,11);
		
		
		shuffle($this->operators);
		if($this->operators[0] == '*'){
			$session_var = $this->math((int)$this->first_num,(int)$this->second_num);
		}else if($this->operators[0] == '+'){
			$session_var = $this->add((int)$this->first_num,(int)$this->second_num);
		}else if($this->operators[0] == '-'){
			$session_var = $this->subtract((int)$this->first_num,(int)$this->second_num);
		}
		
		$this->CI->session->set_userdata('security_number',$session_var);
		/* 
			save the operation result in session to make verifications
		*/
		$img = imagecreate( $this->captcha_w, $this->captcha_h );
		
		
		/*
			Some colors. Text is $black, background is $white, grid is $grey
		*/
		$black = imagecolorallocate($img,0,0,0);
		$white = imagecolorallocate($img,255,255,255);
		$grey = imagecolorallocate($img,215,215,215);
		/*
			make the background white
		*/
		imagefill( $img, 0, 0, $white );	
		/* the background grid lines - vertical lines */
		for ($t = $this->bg_size; $t<$this->captcha_w; $t+=$this->bg_size){
			imageline($img, $t, 0, $t, $this->captcha_h, $grey);
		}
		/* background grid - horizontal lines */
		for ($t = $this->bg_size; $t<$this->captcha_h; $t+=$this->bg_size){
			imageline($img, 0, $t, $this->captcha_w, $t, $grey);
		}
		
		/* 
			this determinates the available space for each operation element 
			it's used to position each element on the image so that they don't overlap
		*/
		$item_space = $this->captcha_w/3;
		
		/* first number */
		imagettftext(
			$img,
			rand(
				$this->min_font_size,
				$this->max_font_size
			),
			rand( -$this->angle , $this->angle ),
			rand( 10, $item_space-20 ),
			rand( 25, $this->captcha_h-25 ),
			$black,
			$this->font_path,
			$this->second_num);
		
		/* operator */
		imagettftext(
			$img,
			rand(
				$this->min_font_size,
				$this->max_font_size
			),
			rand( -$this->angle, $this->angle ),
			rand( $item_space, 2*$item_space-20 ),
			rand( 25, $this->captcha_h-25 ),
			$black,
			$this->font_path,
			$this->operators[0]);
		
		/* second number */
		imagettftext(
			$img,
			rand(
				$this->min_font_size,
				$this->max_font_size
			),
			rand( -$this->angle, $this->angle ),
			rand( 2*$item_space, 3*$item_space-20),
			rand( 25, $this->captcha_h-25 ),
			$black,
			$this->font_path,
			$this->first_num);
			
		/* image is .jpg */
		//header("Content-type:image/jpeg");
		/* name is secure.jpg */
		//header("Content-Disposition:inline ; filename=secure.jpg");
		/* output image */
		imagejpeg($img);
		
	}
	
	function math($num1,$num2){
		return $num1*$num2;
	}
	function add($num1,$num2){
		return $num1+$num2;
	}
	function subtract($num1,$num2){
		return $num1-$num2;
	}
}