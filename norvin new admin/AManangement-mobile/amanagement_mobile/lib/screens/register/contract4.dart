import 'package:flutter/material.dart';
import '../register/contract3.dart';

class ConfirmationScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Confirm Contract")),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Column(
          children: [
            Text("Property: Property 1"),
            Text("Room: Room A"),
            Text("Rent: \$1200.00"),
            Text("Start Date: 2024-01-01"),
            Text("Auto-Renew: Yes"),
            Text("Payment Frequency: Monthly"),
            Spacer(),
            ElevatedButton(
              onPressed: () {
                // Submit the contract
              },
              child: Text("Confirm and Submit"),
            ),
          ],
        ),
      ),
    );
  }
}
