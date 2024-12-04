import 'package:flutter/material.dart';
import 'contract2.dart';

class ContractOptionsScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Contract Options")),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Column(
          children: [
            SwitchListTile(
              title: Text("Auto-Renew Contract"),
              value: true, // Default value
              onChanged: (value) {
                // Update auto-renew option
              },
            ),
            TextField(
              decoration: InputDecoration(
                labelText: "Special Terms",
                hintText: "Enter any additional terms...",
              ),
              maxLines: 3,
            ),
            Spacer(),
            ElevatedButton(
              onPressed: () {
                // Navigate to the confirmation screen
              },
              child: Text("Next"),
            ),
          ],
        ),
      ),
    );
  }
}
