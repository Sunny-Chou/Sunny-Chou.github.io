using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace maze
{
    /// <summary>
    /// MainWindow.xaml 的互動邏輯
    /// </summary>
    public partial class MainWindow : Window
    {
        private int[,] move = { { -1, 0 }, { -1, 1 }, { 0, 1 }, { 1, 1 }, { 1, 0 }, { 1, -1 }, { 0, -1 }, { -1, -1 } };
        private Random random = new Random();
        private int least=1;
        private int[,] maze;
        private int[,] maze2;
        private int[,] p;
        private SolidColorBrush colorbrush = new SolidColorBrush();
        private SolidColorBrush colorbrush1 = new SolidColorBrush();
        private SolidColorBrush colorbrush2 = new SolidColorBrush();
        private SolidColorBrush colorbrush3 = new SolidColorBrush();
        private int[] mazeIn = new int[2];
        private int[] mazeOut = new int[2];
        private double width;
        private double height;
        private int r=-1;
        private int c=-1;
        private int count = 0;
        public void Path()
        {
            p = null;
            p = new int[maze.GetLength(0)*maze.GetLength(1), 2];
            if (maze.GetLength(0)>=least+2&& maze.GetLength(1) >= least+2) {
                for(int i = 0; i < maze.GetLength(0); i++)
                {
                    for(int j = 0; j < maze.GetLength(1); j++)
                    {
                        maze2[i, j] = maze[i, j];
                    }
                }
                int rnow = mazeIn[0];
                int cnow = mazeIn[1];
                count = 0;
                maze2[rnow, cnow] = 1;
                p[count,0] = rnow;
                p[count,1] = cnow;
                bool goback = true;
                do
                    {
                    for (int i = 0; i < 8; i++)
                    {
                        if (rnow + move[i, 0] >= 0 && rnow + move[i, 0] < maze.GetLength(0) && cnow + move[i, 1] >= 0 && cnow + move[i, 1] < maze.GetLength(1))
                        {
                            if (maze2[rnow + move[i, 0], cnow + move[i, 1]] == 0)
                            {

                                rnow += move[i, 0];
                                cnow += move[i, 1];
                                maze2[rnow, cnow] = 1;
                                count++;
                                p[count, 0] = rnow;
                                p[count, 1] = cnow;
                                goback = false;
                                break;
                            }

                        }

                    }
                    if (goback)
                    {
                        --count;
                        if (count >= 0)
                        {

                            rnow = p[count, 0];
                            cnow = p[count, 1];
                        }
                        else
                        {
                            break;
                        }


                    }
                    goback = true;

                } while (rnow != mazeOut[0] || cnow != mazeOut[1]);

            }

            else { 
                count = 0;
            }
                
            
        }
        




        private void CreateRectangle()
        {
            pt.Text = "";
            colorbrush.Color = Color.FromRgb(0, 0, 0);
            colorbrush1.Color = Color.FromRgb(255, 255, 255);
            colorbrush2.Color = Color.FromRgb(174, 254, 221);
            m.Children.Clear();

            width = (this.m.ActualWidth) / (maze.GetLength(1) + 1);
            height = (this.m.ActualHeight) / (maze.GetLength(0) + 1);
            width = Math.Min(width, height);
            height = Math.Min(width, height);
            for (int i = 0; i < maze.GetLength(0); i++)
            {
                for (int j = 0; j < maze.GetLength(1); j++)
                {
                    Rectangle rt = new Rectangle()
                    {
                        Width = width,
                        Height = height

                    };
                    if (maze[i, j] == 1)
                    {
                        
                        
                        if (r == i && c == j)
                        {
                            rt.Fill = colorbrush2;
                            rt.Stroke = colorbrush2;
                        }
                        else
                        {
                            rt.Fill = colorbrush;
                            rt.Stroke = colorbrush;
                        }
                        
                    }
                    else
                    {
                        rt.Fill = colorbrush1;
                        if (r == i && c == j)
                        {
                            rt.Fill = colorbrush2;
                            rt.Stroke = colorbrush2;
                        }
                        else
                        {
                            rt.Stroke = colorbrush;
                        }
                    }
                    
                    Canvas.SetTop(rt, i * height);
                    Canvas.SetLeft(rt, j * width);
                    
                    m.Children.Add(rt);




                }
            }
        }
        private void CreateMaze(object sender, RoutedEventArgs e)
    {
            int rown, coln;
        try
        {
            if (row.Text.All(char.IsDigit) && col.Text.All(char.IsDigit))
            {
                rown = Int32.Parse(row.Text);
                coln = Int32.Parse(col.Text);
                if (rown >= least && coln >= least)
                {
                    maze = new int[rown + 2, coln + 2];
                    maze2 = new int[rown + 2, coln + 2];
                    for (int i = 0; i < rown + 2; i++)
                    {

                        for (int j = 0; j < coln + 2; j++)
                        {
                            if (i == 0 || j == 0 || i == rown + 1 || j == coln + 1)
                            {
                                maze[i, j] = 1;
                            }
                            else
                            {
                                maze[i, j] = random.Next(2);

                            }

                        }
                    }
                    int In;
                    int Out;
                    do
                    {
                        In = random.Next(2 * (rown + 2) + 2 * (coln + 2) + -5);
                        Out = random.Next(2 * (rown + 2) + 2 * (coln + 2) + -5);
                    } while (In == Out);

                    if (In < coln + 2)
                    {
                        maze[0, In] = 0;
                        mazeIn[0] = 0;
                        mazeIn[1] = In;
                    }
                    else if (In - coln - 2 < rown + 1)
                    {
                        maze[In - coln - 1, coln + 1] = 0;
                        mazeIn[0] = In - coln - 1;
                        mazeIn[1] = coln + 1;
                    }
                    else if (In - coln - 2 - rown - 1 < coln + 1)
                    {
                        maze[rown + 1, In - coln - 3 - rown] = 0;
                        mazeIn[0] = rown + 1;
                        mazeIn[1] = In - coln - 3 - rown;
                    }
                    else
                    {
                        maze[In - 2 * coln - 3 - rown, 0] = 0;
                        mazeIn[0] = In - 2 * coln - 3 - rown;
                        mazeIn[1] = 0;
                    }

                    if (Out < coln + 2)
                    {
                        maze[0, Out] = 0;
                        mazeOut[0] = 0;
                        mazeOut[1] = Out;
                    }
                    else if (Out - coln - 2 < rown + 1)
                    {
                        maze[Out - coln - 1, coln + 1] = 0;
                        mazeOut[0] = Out - coln - 1;
                        mazeOut[1] = coln + 1;
                    }
                    else if (Out - coln - 2 - rown - 1 < coln + 1)
                    {
                        maze[rown + 1, Out - coln - 3 - rown] = 0;
                        mazeOut[0] = rown + 1;
                        mazeOut[1] = Out - coln - 3 - rown;
                    }
                    else
                    {
                        maze[Out - 2 * coln - 3 - rown, 0] = 0;
                        mazeOut[0] = Out - 2 * coln - 3 - rown;
                        mazeOut[1] = 0;
                    }

                    CreateRectangle();

                }
            }
        }
        catch
        {
            m.Children.Clear();
            p = null;
            maze = null;
            maze2 = null;
        }
    }



        protected void TextChanged(object sender, TextChangedEventArgs e)
        {
            try
            {
                if(row_change.Text.All(char.IsDigit) && col_change.Text.All(char.IsDigit)&&maze.GetLength(0)>0&&maze.GetLength(1)>0)
                {
                    r = Int32.Parse(row_change.Text);
                    c = Int32.Parse(col_change.Text);
                    if(r< maze.GetLength(0) && c < maze.GetLength(1)&&r>=0&&c>=0)
                    {
                        CreateRectangle();
                    }
                    else
                    {
                        r = -1;
                        c = -1;
                        CreateRectangle();
                        
                    }
                }
            }
            catch
            {
                r = -1;
                c = -1;
                CreateRectangle();

            }
        }
       
        public MainWindow()
        {
            InitializeComponent();
        }

        private void Makewall(object sender, RoutedEventArgs e)
        {
            if (r > 0 && c > 0 && r < maze.GetLength(0)-1 && c < maze.GetLength(1)-1)
            {
                maze[r, c] = 1;
                CreateRectangle();

            }
        }

        private void Deletewall(object sender, RoutedEventArgs e)
        {
            if (r > 0 && c > 0 && r < maze.GetLength(0)-1 && c < maze.GetLength(1)-1)
            {
                maze[r, c] = 0;
                CreateRectangle();

            }

        }

        private void Createpath(object sender, RoutedEventArgs e)
        {
            Path();
            if (count > 0)
            {
                colorbrush3.Color = Color.FromRgb(255,0,0);
                for(int i = 0; i <= count; i++)
                {
                    Rectangle rt = new Rectangle()
                    {
                        Width=width,
                        Height=height
                    };
                    Canvas.SetTop(rt, p[i, 0]*height);
                    Canvas.SetLeft(rt, p[i, 1]*width);
                    rt.Fill = colorbrush3;
                    m.Children.Add(rt);

                    TextBlock tb = new TextBlock()
                    {
                        Text = Convert.ToString(i),
                        
                    };
                    Canvas.SetTop(tb, p[i, 0] * height);
                    Canvas.SetLeft(tb, p[i, 1] * width);
                    m.Children.Add(tb);
                }
                pt.Text = "Path Lengh : "+Convert.ToString(count);
                
            }
            else
            {
                pt.Text = "There is no path.";
                
                
            }
        }

        private void Changein(object sender, RoutedEventArgs e)
        {
            if (r == 0 || c == 0 || r == maze.GetLength(0)-1 || c == maze.GetLength(1)-1)
            {
                if (r != mazeOut[0] || c != mazeOut[1])
                {
                    maze[mazeIn[0], mazeIn[1]] = 1;
                    maze[r, c] = 0;
                    mazeIn[0] = r;
                    mazeIn[1] = c;
                    CreateRectangle();

                }
                
            }
        }

        private void Changeout(object sender, RoutedEventArgs e)
        {
            if (r == 0 || c == 0 || r == maze.GetLength(0) - 1 || c == maze.GetLength(1) - 1)
            {
                if (r != mazeIn[0] || c != mazeIn[1])
                {
                    maze[mazeOut[0], mazeOut[1]] = 1;
                    maze[r, c] = 0;
                    mazeOut[0] = r;
                    mazeOut[1] = c;
                    CreateRectangle();
                }
                

            }
        }

    }
}
