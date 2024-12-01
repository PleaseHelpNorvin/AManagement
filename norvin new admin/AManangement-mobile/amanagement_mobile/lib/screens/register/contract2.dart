
import 'package:flutter/material.dart';
import '../register/contract1.dart';

class PaymentDetailsScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Payment Details")),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Column(
          children: [
            Text("Rent Amount: \$1200.00"),
            Text("Security Payment: \$600.00"),
            RadioListTile<String>(
              title: Text("Monthly"),
              value: "monthly",
              groupValue: "monthly", // Default value
              onChanged: (value) {
                // Update payment frequency
              },
            ),
            RadioListTile<String>(
              title: Text("Annually"),
              value: "annually",
              groupValue: "monthly",
              onChanged: (value) {},
            ),
            ListTile(
              title: Text("Payment Due Date"),
              trailing: Icon(Icons.calendar_today),
              onTap: () {
                // Show date picker
              },
            ),
            Spacer(),
            ElevatedButton(
              onPressed: () {
                // Navigate to the next screen
              },
              child: Text("Next"),
            ),
          ],
        ),
      ),
    );
  }
}
