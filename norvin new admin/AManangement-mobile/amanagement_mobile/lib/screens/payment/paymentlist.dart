// import 'package:flutter/material.dart';
// import 'package:http/http.dart' as http;

// class PaymentListScreen extends StatefulWidget {
//   final String token;
//   final int userId;

//   PaymentListScreen({
//     required this.token,
//     required this.userId,
//   });

//   @override
//   _PaymentListScreenState createState() => _PaymentListScreenState();
// }

// class _PaymentListScreenState extends State<PaymentListScreen> {
//   bool isLoading = true;
//   String errorMessage = '';
//   List<Payment> payments = [];

//   @override
//   void initState() {
//     super.initState();
//     _fetchPaymentData();
//   }

//   Future<void> _fetchPaymentData() async {
//     try {
//       final response = await http.get(
//         Uri.parse('http://127.0.0.1:8000/api/payments/${widget.userId}'),
//         headers: {
//           'Authorization': 'Bearer ${widget.token}',
//         },
//       );

//       if (response.statusCode == 200) {
//         // Assuming response body contains a list of payments
//         final data = jsonDecode(response.body);
//         setState(() {
//           payments = data.map<Payment>((item) => Payment.fromJson(item)).toList();
//           isLoading = false;
//         });
//       } else {
//         setState(() {
//           isLoading = false;
//           errorMessage = 'Failed to load payments';
//         });
//       }
//     } catch (e) {
//       setState(() {
//         isLoading = false;
//         errorMessage = 'Error: $e';
//       });
//     }
//   }

//   @override
//   Widget build(BuildContext context) {
//     if (isLoading) {
//       return Center(child: CircularProgressIndicator());
//     }

//     if (errorMessage.isNotEmpty) {
//       return Center(child: Text(errorMessage));
//     }

//     return ListView.builder(
//       itemCount: payments.length,
//       itemBuilder: (context, index) {
//         final payment = payments[index];
//         return ListTile(
//           title: Text(payment.amount.toString()),
//           subtitle: Text(payment.date),
//         );
//       },
//     );
//   }
// }
