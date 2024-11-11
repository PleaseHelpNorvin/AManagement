import 'package:flutter/material.dart';

class PayDuePage extends StatelessWidget {
  const PayDuePage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pay Due'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            const Text(
              'Here you can pay your due!',
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 20),
            // Add more content, buttons, or forms as needed
            ElevatedButton(
              onPressed: () {
                // Action for the button (e.g., submit payment)
              },
              child: const Text('Submit Payment'),
            ),
          ],
        ),
      ),
    );
  }
}
