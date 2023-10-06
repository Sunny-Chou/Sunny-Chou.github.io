package com.example.a8_02;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

public class MainActivity extends AppCompatActivity {
    private EditText host;
    private Button connectButton;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        host=findViewById(R.id.hostname);
        connectButton=findViewById(R.id.send);
        connectButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                openClientWin();
            }
        });
    }
    public void openClientWin(){
        Intent intent=new Intent(this,ClientWin.class);
        intent.putExtra("Host",host.getText().toString());
        startActivity(intent);
    }
}