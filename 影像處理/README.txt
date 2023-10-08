1. 程式語言
C in Windows 10
2. 程式開發工具
Visual Studio 2022
3. 電腦硬體
處理器	Intel(R) Core(TM) i5-9300H CPU @ 2.40GHz   2.40 GHz
已安裝記憶體(RAM)	8.00 GB (7.81 GB 可用)
系統類型	64 位元作業系統，x64 型處理器
手寫筆與觸控	手寫筆支援
4. Input檔
Original Lena：lena.pgm
5. Output檔
Processed Lena：lena2.pgm
Histogram values of Original Lena：h1.txt
Histogram values of Processed Lena：h2.txt

註解：
Step1：讀掉前兩行(第一行是檔案種類，第二行是註解)
Step2：讀第三行得知高與寬
Step3：讀掉第四行(第四行是最高灰階值)
Step4：運用高與寬來迴圈，一邊讀一邊數灰階值=k的pixel數量放到nk中
Step5：計算所有的pr(rk)=nk/(高*寬)
Step6：計算所有sk=(pr(r0~rk)機率加總)*255
Step7：將每個原本是k的pixel的數量放到n2sk四捨五入的值中，就成功計算出新的Lena的nk值n2k了
Step8：計算ps(sk)值=p2r(rk)=n2k/(高*寬)
Step9：將每個原本是k的pixel轉成sk四捨五入的值
Step10：按照用txt打開的格式內容輸出成pgm檔