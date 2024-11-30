import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Register1 extends StatelessWidget {
  // Function to save the selected payment frequency
  Future<void> savePaymentFrequency(String paymentType) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setString('payment_frequency', paymentType);
    print('Payment frequency saved: $paymentType');
  }

  // Function to retrieve the selected payment frequency
  Future<String?> getPaymentFrequency() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    return prefs.getString('payment_frequency');
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // appBar: AppBar(
      //   title: Text('Centered Buttons'),
      // ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center, // Centers vertically
          crossAxisAlignment: CrossAxisAlignment.center, // Centers horizontally
          children: [
            // Sentence above the buttons
            const Text(
              'Please choose a payment frequency:\n'
              'You can select monthly, annually, or one-time payment.',
              textAlign: TextAlign.center, // Center the text
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
              ),
            ),
            SizedBox(height: 30), // Adds space between the text and buttons
            ElevatedButton(
              onPressed: () {
                // Save monthly payment choice
                savePaymentFrequency('monthly');
              },
              style: ElevatedButton.styleFrom(
                minimumSize: Size(200, 60), // Make the button larger
                padding: EdgeInsets.symmetric(vertical: 20, horizontal: 50), // Increase padding
                textStyle: TextStyle(fontSize: 18), // Make text larger
              ),
              child: Text('Monthly'),
            ),
            SizedBox(height: 20), // Adds space between the buttons
            ElevatedButton(
              onPressed: () {
                // Save annual payment choice
                savePaymentFrequency('annually');
              },
              style: ElevatedButton.styleFrom(
                minimumSize: Size(200, 60), // Make the button larger
                padding: EdgeInsets.symmetric(vertical: 20, horizontal: 50), // Increase padding
                textStyle: TextStyle(fontSize: 18), // Make text larger
              ),
              child: Text('Annually'),
            ),
            SizedBox(height: 20), // Adds space between the buttons
            ElevatedButton(
              onPressed: () {
                // Save one-time payment choice
                savePaymentFrequency('one_time');
              },
              style: ElevatedButton.styleFrom(
                minimumSize: Size(200, 60), // Make the button larger
                padding: EdgeInsets.symmetric(vertical: 20, horizontal: 50), // Increase padding
                textStyle: TextStyle(fontSize: 18), // Make text larger
              ),
              child: Text('One-time'),
            ),
            SizedBox(height: 30),
            // Button to retrieve the saved payment frequency
            ElevatedButton(
              onPressed: () async {
                String? paymentType = await getPaymentFrequency();
                print('Saved payment frequency: $paymentType');
                // Show the saved payment frequency in a dialog
                showDialog(
                  context: context,
                  builder: (context) {
                    return AlertDialog(
                      title: Text('Saved Payment Frequency'),
                      content: Text(paymentType ?? 'No payment frequency selected'),
                      actions: [
                        TextButton(
                          onPressed: () {
                            Navigator.of(context).pop();
                          },
                          child: Text('OK'),
                        ),
                      ],
                    );
                  },
                );
              },
              style: ElevatedButton.styleFrom(
                minimumSize: Size(200, 60), // Make the button larger
                padding: EdgeInsets.symmetric(vertical: 20, horizontal: 50), // Increase padding
                textStyle: TextStyle(fontSize: 18), // Make text larger
              ),
              child: Text('Retrieve Saved Payment'),
            ),
          ],
        ),
      ),
    );
  }
}
