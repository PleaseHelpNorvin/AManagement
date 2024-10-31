import 'package:flutter/material.dart';

class ProfileScreen extends StatelessWidget {
  const ProfileScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profile'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Profile Information',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            // Example Profile Data
            ListTile(
              title: const Text('Name'),
              subtitle: const Text('John Doe'), // Replace with actual data
            ),
            ListTile(
              title: const Text('Email'),
              subtitle: const Text('john.doe@example.com'), // Replace with actual data
            ),
            ListTile(
              title: const Text('Payment Method'),
              subtitle: const Text('Visa **** 1234'), // Replace with actual data
            ),
            // Add a button to update payment methods or billing info
            ElevatedButton(
              onPressed: () {
                // Navigate to update payment method screen
              },
              child: const Text('Update Payment Method'),
            ),
          ],
        ),
      ),
    );
  }
}
