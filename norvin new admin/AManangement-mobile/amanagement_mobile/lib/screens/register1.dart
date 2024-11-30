import 'package:flutter/material.dart';

class Register1 extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Centered Buttons'),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center, // Centers vertically
          crossAxisAlignment: CrossAxisAlignment.center, // Centers horizontally
          children: [
            ElevatedButton(
              onPressed: () {
                // Action for Button 1
                print('Button 1 pressed');
              },
              child: Text('Button 1'),
            ),
            SizedBox(height: 20), // Adds space between the buttons
            ElevatedButton(
              onPressed: () {
                // Action for Button 2
                print('Button 2 pressed');
              },
              child: Text('Button 2'),
            ),
            SizedBox(height: 20), // Adds space between the buttons
            ElevatedButton(
              onPressed: () {
                // Action for Button 3
                print('Button 3 pressed');
              },
              child: Text('Button 3'),
            ),
          ],
        ),
      ),
    );
  }
}
