<?
	class cl_seo extends cl_db
	{
		// метод для показа формы для сео
		public function FormSeo($id, $title, $description, $keywords)
		{
			echo '<table border="0" style="margin: 0 0 0 15px;">
				<input type="hidden" name="seo_id" value="'.$id.'" size="40" />
				<tr><td align="left"><h3>Раздел SEO</h3></td></tr>
				<tr><td align="left">заголовок страницы:</td></tr>
				<tr><td><input type="text" name="seo_title" value="'.$title.'" size="40" /></td></tr>
				<tr><td align="left">описание страницы:</td></tr>
				<tr><td><textarea name="seo_description" cols="30" rows="5">'.$description.'</textarea></td></tr>
				<tr><td align="left">ключевые слова:</td></tr>
				<tr><td><textarea name="seo_keywords" cols="30" rows="5">'.$keywords.'</textarea></td></tr>
			</table>';
		}
		
		// метод для выборки даных сео, возвращяет масив с трьох елементов: заголовок, описание, ключевые слова
		public function SelectSeo($id)
		{
			$this->getdriver()->Select('t_seo', '', 'seo_id='.$id, '', '', '', '', ''); 
			$row = $this->getdriver()->FetchResult();
			$mas_seo[0] = $this->getdriver()->Strip($row["seo_id"]);
			$mas_seo[1] = $this->getdriver()->Strip($row["seo_title"]);
			$mas_seo[2] = $this->getdriver()->Strip($row["seo_description"]);
			$mas_seo[3] = $this->getdriver()->Strip($row["seo_keywords"]);
			return $mas_seo;
		}		
		
		// метод для добавления даных в таблицу сео и возвращает результат
		public function InsertSeo($title, $description, $keywords) 
		{
				$insert_names = "seo_title, seo_description, seo_keywords";
				$insert_values = "'".$title."', '".$description."', '".$keywords."'";
				$this->getdriver()->Insert('t_seo', $insert_names, $insert_values);
				$res = $this->getdriver()->Result();
				return $res;
		}
		
		// метод для редактирования даных из таблицы сео и возвращает результат
		public function UpdateSeo($id, $title, $description, $keywords) 
		{
			$updt_names = "seo_title, seo_description, seo_keywords";
			$updt_values = array("'".$title."'", "'".$description."'", "'".$keywords."'");
			$this->getdriver()->Update('t_seo', $updt_names, $updt_values, 'seo_id='.$id);
			$res = $this->getdriver()->Result();
			return $res;
		}
		
		// метод для удаления даных с таблицы сео и возвращает результат
		public function DeleteSeo($id_delete)
		{
			/* for($i=0; $i<count($id_delete); $i++)
			{
				$this->getdriver()->Delete('t_seo', 'seo_id='.$id_delete[$i]);
				$res = $this->getdriver()->Result();
			}
			return $res; */
			
			$this->getdriver()->Delete('t_seo', 'seo_id='.$id_delete);
			$res = $this->getdriver()->Result();
			return $res;
		}
	}
?>