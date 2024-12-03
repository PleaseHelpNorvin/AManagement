import 'package:flutter/material.dart';
import '../register/contract3.dart';

class Contract2 extends StatefulWidget {
  final int userId;
  final String email;
  final String name;
  final String token;
  final int propertyId;
  final String roomCode;
  final double rentAmount;


  Contract2({
    required this.token,
    required this.userId,
    required this.email,
    required this.name,
    required this.propertyId,
    required this.roomCode,
    required this.rentAmount,
  });

  @override
  PaymentFrequencyScreenState createState() => PaymentFrequencyScreenState();
}

class PaymentFrequencyScreenState extends State<Contract2> {
  void navigateToContract3(String paymentFrequency) {
  Navigator.push(
    context,
    MaterialPageRoute(
      builder: (context) => Contract3(
        token: widget.token,
        userId: widget.userId,
        email: widget.email,
        name: widget.name,
        propertyId: widget.propertyId,
        roomCode: widget.roomCode,      // Pass roomCode
        rentAmount: widget.rentAmount,  // Pass rentAmount
        paymentFrequency: paymentFrequency,
      ),
    ),
  );
}


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Select Payment Frequency"),
        backgroundColor: Colors.blueAccent,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Text(
              "Thank you  for choosing Room: ${widget.roomCode}",
              textAlign: TextAlign.center,
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
                color: Colors.black87,
              ),
            ),
            Text(
              "Choose the payment frequency for the contract:",
              textAlign: TextAlign.center,
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
                color: Colors.black87,
              ),
            ),
            SizedBox(height: 30),
            // Use ListView without Expanded to let it scroll when needed
            ListView(
              shrinkWrap: true,  // Make ListView take only as much space as needed
              children: [
                buildCircularButton(
                  "Monthly",
                  Colors.blue,
                  Icons.calendar_today,
                  () => navigateToContract3("monthly"),
                ),
                SizedBox(height: 30),
                buildCircularButton(
                  "Annual",
                  Colors.green,
                  Icons.event,
                  () => navigateToContract3("annual"),
                ),
                SizedBox(height: 30),
                buildCircularButton(
                  "One-Time",
                  Colors.orange,
                  Icons.payment,
                  () => navigateToContract3("one-time"),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }


  /// Method to build a circular button
  Widget buildCircularButton(
    String label,
    Color color,
    IconData icon,
    VoidCallback onPressed,
  ) {
    return GestureDetector(
      onTap: onPressed,
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          CircleAvatar(
            radius: 50, // Adjust size as needed
            backgroundColor: color,
            child: Icon(
              icon,
              color: Colors.white,
              size: 32,
            ),
          ),
          SizedBox(height: 8),
          Text(
            label,
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.bold,
              color: Colors.black87,
            ),
          ),
        ],
      ),
    );
  }
}
