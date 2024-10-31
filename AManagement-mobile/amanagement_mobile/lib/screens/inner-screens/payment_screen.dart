import 'package:flutter/material.dart';

class PaymentsScreen extends StatelessWidget {
  const PaymentsScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Payments'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Payment History',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            // Example Payment Data
            Expanded(
              child: ListView.builder(
                itemCount: 5, // Example count; replace with actual data count
                itemBuilder: (context, index) {
                  return Card(
                    margin: const EdgeInsets.symmetric(vertical: 8.0),
                    child: ListTile(
                      title: Text('Payment #${index + 1}'),
                      subtitle: const Text('Status: Completed'), // Replace with actual status
                      trailing: const Text('\$100.00'), // Replace with actual amount
                      onTap: () {
                        // Navigate to payment details screen
                      },
                    ),
                  );
                },
              ),
            ),
            // Button to initiate a new payment
            ElevatedButton(
              onPressed: () {
                // Navigate to new payment screen
              },
              child: const Text('Make a New Payment'),
            ),
          ],
        ),
      ),
    );
  }
}
