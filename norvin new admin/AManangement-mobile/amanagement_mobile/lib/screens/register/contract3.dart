import 'package:flutter/material.dart';
import 'package:intl/intl.dart'; // For date formatting

class Contract3 extends StatefulWidget {
  final int userId;
  final String email;
  final String name;
  final String token;
  final int propertyId;
  final String roomCode;
  final double rentAmount;
  final String paymentFrequency;

  Contract3({
    required this.token,
    required this.userId,
    required this.email,
    required this.name,
    required this.propertyId,
    required this.roomCode,
    required this.rentAmount,
    required this.paymentFrequency,
  });

  @override
  PaymentDetailsScreenState createState() => PaymentDetailsScreenState();
}

class PaymentDetailsScreenState extends State<Contract3> {
  @override
  Widget build(BuildContext context) {
    DateTime currentDate = DateTime.now();
    DateTime monthlyDueDate = currentDate.add(Duration(days: 30)); // Due date is 1 month from today
    DateTime warningDate = monthlyDueDate.subtract(Duration(days: 2)); // Warning 2 days before due date
    DateTime annualDueDate = currentDate.add(Duration(days: 365)); // Renewal date is 1 year from today
    DateTime annualWarningDate = annualDueDate.add(Duration(days: 2));


    // Format dates
    String formattedMonthlyDueDate = DateFormat('yyyy-MM-dd').format(monthlyDueDate);
    String formattedWarningDate = DateFormat('yyyy-MM-dd').format(warningDate);
    String formattedAnnualDueDate = DateFormat('yyyy-MM-dd').format(annualDueDate);
    String formattedAnnualWarningDate = DateFormat('yyyy-MM-dd').format(annualWarningDate);

    return Scaffold(
      appBar: AppBar(
        title: Text("Payment Details (${widget.paymentFrequency.toUpperCase()})"),
        centerTitle: true,
        backgroundColor: Colors.blueAccent,
      ),
      body: Column(
        children: [
          Expanded(
            child: SingleChildScrollView(
              padding: EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center, // Center items horizontally
                children: [
                  // Thank you message above the contract details
                  Padding(
                    padding: const EdgeInsets.symmetric(vertical: 16.0),
                    child: Text(
                      "Thank you for choosing Room: ${widget.roomCode}",
                      style: TextStyle(
                        fontSize: 22,
                        fontWeight: FontWeight.bold,
                        color: Colors.black87,
                      ),
                    ),
                  ),
                  if (widget.paymentFrequency == "monthly") ...[
                    _buildContractCard(
                      title: "Monthly Contract Details",
                      content: [
                        _buildDetailText("Monthly Rent Amount: \$${widget.rentAmount}"),
                        _buildDetailText("Payment Due Date: $formattedMonthlyDueDate"),
                        _buildDetailText("Warning Date: $formattedWarningDate", isWarning: true),
                      ],
                    ),
                  ],
                  if (widget.paymentFrequency == "annual") ...[
                    _buildContractCard(
                      title: "Annual Contract Details",
                      content: [
                        _buildDetailText("Annual Rent Amount: \$${widget.rentAmount}"),
                        _buildDetailText("Renewal Date: $formattedAnnualDueDate"),
                        _buildDetailText("Anual Warning Date: $formattedAnnualWarningDate", isWarning: true),
                      ],
                    ),
                  ],
                  if (widget.paymentFrequency == "one-time") ...[
                    _buildContractCard(
                      title: "One-Time Contract Details",
                      content: [
                        _buildInputField("Total Rent Amount"),
                        _buildInputField("Lease End Date"),
                      ],
                    ),
                  ],
                ],
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: ElevatedButton(
              onPressed: () {
                // Handle form submission logic
              },
              style: ElevatedButton.styleFrom(
                padding: EdgeInsets.symmetric(vertical: 16.0),
                backgroundColor: Colors.blueAccent,
                textStyle: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                minimumSize: Size(double.infinity, 56), // Full-width button
              ),
              child: Text("Submit"),
            ),
          ),
        ],
      ),
    );
  }

  // Helper method to create contract detail sections
  Widget _buildContractCard({required String title, required List<Widget> content}) {
    return Center(  // Center the card horizontally
      child: Card(
        elevation: 4.0,
        margin: EdgeInsets.symmetric(vertical: 10.0),
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
        child: Padding(
          padding: EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black87),
              ),
              SizedBox(height: 10),
              ...content,
            ],
          ),
        ),
      ),
    );
  }

  // Helper method for creating Text widget with styled details
  Widget _buildDetailText(String text, {bool isWarning = false}) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: Text(
        text,
        style: TextStyle(
          fontSize: 16,
          color: isWarning ? Colors.red : Colors.black,
        ),
      ),
    );
  }

  // Helper method for creating input fields
  Widget _buildInputField(String labelText) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8.0),
      child: TextField(
        decoration: InputDecoration(
          labelText: labelText,
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
            borderSide: BorderSide(color: Colors.blueAccent),
          ),
          contentPadding: EdgeInsets.symmetric(vertical: 10.0, horizontal: 12.0),
        ),
      ),
    );
  }
}
