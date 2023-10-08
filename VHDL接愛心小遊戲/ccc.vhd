library ieee;
use ieee.std_logic_1164.all;
use ieee.std_logic_unsigned.all;
entity c is
port(
clk:in std_logic;
l:in std_logic;
r:in std_logic;
row:out std_logic_vector(15 downto 0);
col:out std_logic_vector(3 downto 0);
seg:out std_logic_vector(6 downto 0);
seg_en:out std_logic
);
end c;
architecture a of c is
signal ledc1: std_logic_vector(15 downto 0):="1111111111111111";
signal ledc2: std_logic_vector(15 downto 0):="1111111111111111";
signal ledc3: std_logic_vector(15 downto 0):="1111111111111111";
signal ledc4: std_logic_vector(15 downto 0):="1111111111111111";
signal ledc5: std_logic_vector(15 downto 0):="1111111111111111";
signal ledc6: std_logic_vector(15 downto 0):="1111111111111001";
signal ledc7: std_logic_vector(15 downto 0):="0111111111110110";
signal ledc8: std_logic_vector(15 downto 0):="0111111111101101";
signal ledc9: std_logic_vector(15 downto 0):="0111111111110110";
signal ledc10:std_logic_vector(15 downto 0):="1111111111111001";
signal ledc11:std_logic_vector(15 downto 0):="1111111111111111";
signal ledc12:std_logic_vector(15 downto 0):="1111111111111111";
signal ledc13:std_logic_vector(15 downto 0):="1111111111111111";
signal ledc14:std_logic_vector(15 downto 0):="1111111111111111";
signal ledc15:std_logic_vector(15 downto 0):="1111111111111111";
signal ledc16:std_logic_vector(15 downto 0):="1111111111111111";---bottom
signal c:std_logic_vector(3 downto 0);
signal counter:std_logic_vector(19 downto 0);
signal point_one:integer:=0;
signal point_ten:integer:=0;
signal heart:integer:=0;
signal bottom:integer:=7;
signal en:std_logic;
signal c2:std_logic_vector(3 downto 0);
begin
process(clk)
begin
if(clk'event and clk='1')then
case c is
when "0000" =>row<=ledc1;col<=c;
when "0001" =>row<=ledc2;col<=c;
when "0010" =>row<=ledc3;col<=c;
when "0011" =>row<=ledc4;col<=c;
when "0100" =>row<=ledc5;col<=c;
when "0101" =>row<=ledc6;col<=c;
when "0110" =>row<=ledc7;col<=c;
when "0111" =>row<=ledc8;col<=c;
when "1000" =>row<=ledc9;col<=c;
when "1001" =>row<=ledc10;col<=c;
when "1010" =>row<=ledc11;col<=c;
when "1011" =>row<=ledc12;col<=c;
when "1100" =>row<=ledc13;col<=c;
when "1101" =>row<=ledc14;col<=c;
when "1110" =>row<=ledc15;col<=c;
when "1111" =>row<=ledc16;col<=c;
when others=>null;
end case;
if(counter=1000001)then
if(l='1'and r='0' and bottom>1)then
case bottom is
when 2=>if ledc1(15)='1'then bottom<=bottom-1;end if;
when 3=>if ledc2(15)='1'then bottom<=bottom-1;end if;
when 4=>if ledc3(15)='1'then bottom<=bottom-1;end if;
when 5=>if ledc4(15)='1'then bottom<=bottom-1;end if;
when 6=>if ledc5(15)='1'then bottom<=bottom-1;end if;
when 7=>if ledc6(15)='1'then bottom<=bottom-1;end if;
when 8=>if ledc7(15)='1'then bottom<=bottom-1;end if;
when 9=>if ledc8(15)='1'then bottom<=bottom-1;end if;
when 10=>if ledc9(15)='1'then bottom<=bottom-1;end if;
when 11=>if ledc10(15)='1'then bottom<=bottom-1;end if;
when 12=>if ledc11(15)='1'then bottom<=bottom-1;end if;
when 13=>if ledc12(15)='1'then bottom<=bottom-1;end if;
when 14=>if ledc13(15)='1'then bottom<=bottom-1;end if;
when others=>null;
end case;
end if;
if(r='1'and l='0' and bottom<14)then
case bottom is
when 1=>if ledc4(15)='1'then bottom<=bottom+1;end if;
when 2=>if ledc5(15)='1'then bottom<=bottom+1;end if;
when 3=>if ledc6(15)='1'then bottom<=bottom+1;end if;
when 4=>if ledc7(15)='1'then bottom<=bottom+1;end if;
when 5=>if ledc8(15)='1'then bottom<=bottom+1;end if;
when 6=>if ledc9(15)='1'then bottom<=bottom+1;end if;
when 7=>if ledc10(15)='1'then bottom<=bottom+1;end if;
when 8=>if ledc11(15)='1'then bottom<=bottom+1;end if;
when 9=>if ledc12(15)='1'then bottom<=bottom+1;end if;
when 10=>if ledc13(15)='1'then bottom<=bottom+1;end if;
when 11=>if ledc14(15)='1'then bottom<=bottom+1;end if;
when 12=>if ledc15(15)='1'then bottom<=bottom+1;end if;
when 13=>if ledc16(15)='1'then bottom<=bottom+1;end if;
when others=>null;
end case;
end if;
if(heart>=10 and heart<=12 and((ledc3(14)='0'and ledc3(15)='0')or(ledc4(14)='0'and ledc4(15)='0')or(ledc5(14)='0'and ledc5(15)='0')or(ledc6(14)='0'and ledc6(15)='0')or(ledc7(14)='0'and ledc7(15)='0')or(ledc8(14)='0'and ledc8(15)='0')or(ledc9(14)='0'and ledc9(15)='0')or(ledc10(14)='0'and ledc10(15)='0')or(ledc11(14)='0'and ledc11(15)='0')or(ledc12(14)='0'and ledc12(15)='0')or(ledc13(14)='0'and ledc13(15)='0')or(ledc14(14)='0'and ledc14(15)='0')))then
c2<=c2+c;
case c2 is
when "0000" =>
ledc1 <="1111111111111001";
ledc2 <="1111111111110110";
ledc3 <="1111111111101101";
ledc4 <="1111111111110110";
ledc5 <="1111111111111001";
ledc6 <="1111111111111111";
ledc7 <="1111111111111111";
ledc8 <="1111111111111111";
ledc9 <="1111111111111111";
ledc10<="1111111111111111";
ledc11<="1111111111111111";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "0001" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111001";
ledc3 <="1111111111110110";
ledc4 <="1111111111101101";
ledc5 <="1111111111110110";
ledc6 <="1111111111111001";
ledc7 <="1111111111111111";
ledc8 <="1111111111111111";
ledc9 <="1111111111111111";
ledc10<="1111111111111111";
ledc11<="1111111111111111";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "0010" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111001";
ledc4 <="1111111111110110";
ledc5 <="1111111111101101";
ledc6 <="1111111111110110";
ledc7 <="1111111111111001";
ledc8 <="1111111111111111";
ledc9 <="1111111111111111";
ledc10<="1111111111111111";
ledc11<="1111111111111111";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "0011" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111001";
ledc5 <="1111111111110110";
ledc6 <="1111111111101101";
ledc7 <="1111111111110110";
ledc8 <="1111111111111001";
ledc9 <="1111111111111111";
ledc10<="1111111111111111";
ledc11<="1111111111111111";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "0100" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111001";
ledc6 <="1111111111110110";
ledc7 <="1111111111101101";
ledc8 <="1111111111110110";
ledc9 <="1111111111111001";
ledc10<="1111111111111111";
ledc11<="1111111111111111";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "0101" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111111";
ledc7 <="1111111111111001";
ledc8 <="1111111111110110";
ledc9 <="1111111111101101";
ledc10<="1111111111110110";
ledc11<="1111111111111001";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "0110" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111111";
ledc7 <="1111111111111111";
ledc8 <="1111111111111001";
ledc9 <="1111111111110110";
ledc10<="1111111111101101";
ledc11<="1111111111110110";
ledc12<="1111111111111001";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "0111" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111111";
ledc7 <="1111111111111111";
ledc8 <="1111111111111111";
ledc9 <="1111111111111001";
ledc10<="1111111111110110";
ledc11<="1111111111101101";
ledc12<="1111111111110110";
ledc13<="1111111111111001";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "1000" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111111";
ledc7 <="1111111111111111";
ledc8 <="1111111111111111";
ledc9 <="1111111111111111";
ledc10<="1111111111111001";
ledc11<="1111111111110110";
ledc12<="1111111111101101";
ledc13<="1111111111110110";
ledc14<="1111111111111001";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
when "1001" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111111";
ledc7 <="1111111111111111";
ledc8 <="1111111111111111";
ledc9 <="1111111111111111";
ledc10<="1111111111111111";
ledc11<="1111111111111001";
ledc12<="1111111111110110";
ledc13<="1111111111101101";
ledc14<="1111111111110110";
ledc15<="1111111111111001";
ledc16<="1111111111111111";
when "1010" =>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111111";
ledc7 <="1111111111111111";
ledc8 <="1111111111111111";
ledc9 <="1111111111111111";
ledc10<="1111111111111111";
ledc11<="1111111111111111";
ledc12<="1111111111111001";
ledc13<="1111111111110110";
ledc14<="1111111111101101";
ledc15<="1111111111110110";
ledc16<="1111111111111001";
when others=>
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111001";
ledc7 <="1111111111110110";
ledc8 <="1111111111101101";
ledc9 <="1111111111110110";
ledc10<="1111111111111001";
ledc11<="1111111111111111";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
end case;
if(point_one>=9)then
if(point_ten>=9)then
point_ten<=0;
point_one<=0;
else
point_ten<=point_ten+1;
point_one<=0;
end if;
else
point_one<=point_one+1;
end if;
heart<=0;
counter<=(others=>'0');
else
ledc16<=ledc16(14 downto 0)&'1';
ledc15<=ledc15(14 downto 0)&'1';
ledc14<=ledc14(14 downto 0)&'1';
ledc13<=ledc13(14 downto 0)&'1';
ledc12<=ledc12(14 downto 0)&'1';
ledc11<=ledc11(14 downto 0)&'1';
ledc10<=ledc10(14 downto 0)&'1';
ledc9 <=ledc9(14 downto 0)&'1';
ledc8 <=ledc8(14 downto 0)&'1';
ledc7 <=ledc7(14 downto 0)&'1';
ledc6 <=ledc6(14 downto 0)&'1';
ledc5 <=ledc5(14 downto 0)&'1';
ledc4 <=ledc4(14 downto 0)&'1';
ledc3 <=ledc3(14 downto 0)&'1';
ledc2 <=ledc2(14 downto 0)&'1';
ledc1 <=ledc1(14 downto 0)&'1';
heart<=heart+1;
end if;
if(heart=13)then
heart<=0;
point_one<=0;
point_ten<=0;
bottom<=7;
ledc1 <="1111111111111111";
ledc2 <="1111111111111111";
ledc3 <="1111111111111111";
ledc4 <="1111111111111111";
ledc5 <="1111111111111111";
ledc6 <="1111111111111001";
ledc7 <="1111111111110110";
ledc8 <="1111111111101101";
ledc9 <="1111111111110110";
ledc10<="1111111111111001";
ledc11<="1111111111111111";
ledc12<="1111111111111111";
ledc13<="1111111111111111";
ledc14<="1111111111111111";
ledc15<="1111111111111111";
ledc16<="1111111111111111";
end if;

end if;
if(counter=500000)then
if(l='1'and r='0' and bottom>1)then
case bottom is
when 2=>if ledc1(15)='1'then bottom<=bottom-1;end if;
when 3=>if ledc2(15)='1'then bottom<=bottom-1;end if;
when 4=>if ledc3(15)='1'then bottom<=bottom-1;end if;
when 5=>if ledc4(15)='1'then bottom<=bottom-1;end if;
when 6=>if ledc5(15)='1'then bottom<=bottom-1;end if;
when 7=>if ledc6(15)='1'then bottom<=bottom-1;end if;
when 8=>if ledc7(15)='1'then bottom<=bottom-1;end if;
when 9=>if ledc8(15)='1'then bottom<=bottom-1;end if;
when 10=>if ledc9(15)='1'then bottom<=bottom-1;end if;
when 11=>if ledc10(15)='1'then bottom<=bottom-1;end if;
when 12=>if ledc11(15)='1'then bottom<=bottom-1;end if;
when 13=>if ledc12(15)='1'then bottom<=bottom-1;end if;
when 14=>if ledc13(15)='1'then bottom<=bottom-1;end if;
when others=>null;
end case;
end if;
if(r='1'and l='0' and bottom<14)then
case bottom is
when 1=>if ledc4(15)='1'then bottom<=bottom+1;end if;
when 2=>if ledc5(15)='1'then bottom<=bottom+1;end if;
when 3=>if ledc6(15)='1'then bottom<=bottom+1;end if;
when 4=>if ledc7(15)='1'then bottom<=bottom+1;end if;
when 5=>if ledc8(15)='1'then bottom<=bottom+1;end if;
when 6=>if ledc9(15)='1'then bottom<=bottom+1;end if;
when 7=>if ledc10(15)='1'then bottom<=bottom+1;end if;
when 8=>if ledc11(15)='1'then bottom<=bottom+1;end if;
when 9=>if ledc12(15)='1'then bottom<=bottom+1;end if;
when 10=>if ledc13(15)='1'then bottom<=bottom+1;end if;
when 11=>if ledc14(15)='1'then bottom<=bottom+1;end if;
when 12=>if ledc15(15)='1'then bottom<=bottom+1;end if;
when 13=>if ledc16(15)='1'then bottom<=bottom+1;end if;
when others=>null;
end case;
end if;
end if;
if(counter/=1000001 and counter/=500000)then
case bottom is
when 1=>ledc1<='0'&ledc1(14 downto 0);ledc2<='0'&ledc2(14 downto 0);ledc3<='0'&ledc3(14 downto 0);
when 2=>ledc2<='0'&ledc2(14 downto 0);ledc3<='0'&ledc3(14 downto 0);ledc4<='0'&ledc4(14 downto 0);
when 3=>ledc3<='0'&ledc3(14 downto 0);ledc4<='0'&ledc4(14 downto 0);ledc5<='0'&ledc5(14 downto 0);
when 4=>ledc4<='0'&ledc4(14 downto 0);ledc5<='0'&ledc5(14 downto 0);ledc6<='0'&ledc6(14 downto 0);
when 5=>ledc5<='0'&ledc5(14 downto 0);ledc6<='0'&ledc6(14 downto 0);ledc7<='0'&ledc7(14 downto 0);
when 6=>ledc6<='0'&ledc6(14 downto 0);ledc7<='0'&ledc7(14 downto 0);ledc8<='0'&ledc8(14 downto 0);
when 7=>ledc7<='0'&ledc7(14 downto 0);ledc8<='0'&ledc8(14 downto 0);ledc9<='0'&ledc9(14 downto 0);
when 8=>ledc8<='0'&ledc8(14 downto 0);ledc9<='0'&ledc9(14 downto 0);ledc10<='0'&ledc10(14 downto 0);
when 9=>ledc9<='0'&ledc9(14 downto 0);ledc10<='0'&ledc10(14 downto 0);ledc11<='0'&ledc11(14 downto 0);
when 10=>ledc10<='0'&ledc10(14 downto 0);ledc11<='0'&ledc11(14 downto 0);ledc12<='0'&ledc12(14 downto 0);
when 11=>ledc11<='0'&ledc11(14 downto 0);ledc12<='0'&ledc12(14 downto 0);ledc13<='0'&ledc13(14 downto 0);
when 12=>ledc12<='0'&ledc12(14 downto 0);ledc13<='0'&ledc13(14 downto 0);ledc14<='0'&ledc14(14 downto 0);
when 13=>ledc13<='0'&ledc13(14 downto 0);ledc14<='0'&ledc14(14 downto 0);ledc15<='0'&ledc15(14 downto 0);
when 14=>ledc14<='0'&ledc14(14 downto 0);ledc15<='0'&ledc15(14 downto 0);ledc16<='0'&ledc16(14 downto 0);
when others=>null;
end case;
end if;
if en='1'then
case point_one is
when 0=>seg<="0111111";
when 1=>seg<="0000110";
when 2=>seg<="1011011";
when 3=>seg<="1001111";
when 4=>seg<="1100110";
when 5=>seg<="1101101";
when 6=>seg<="1111101";
when 7=>seg<="0100111";
when 8=>seg<="1111111";
when 9=>seg<="1101111";
when others=>null;
end case;
seg_en<=en;
en<=not en;
else
case point_ten is
when 0=>seg<="0111111";
when 1=>seg<="0000110";
when 2=>seg<="1011011";
when 3=>seg<="1001111";
when 4=>seg<="1100110";
when 5=>seg<="1101101";
when 6=>seg<="1111101";
when 7=>seg<="0100111";
when 8=>seg<="1111111";
when 9=>seg<="1101111";
when others=>null;
end case;
seg_en<=en;
en<=not en;
end if;
c<=c+1;
counter<=counter+1;
end if;
end process;
end a;




