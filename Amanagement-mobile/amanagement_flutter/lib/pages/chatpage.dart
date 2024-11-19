import 'package:flutter/material.dart';
import '../utils/real_time_service.dart';
class ChatPage extends StatefulWidget {
  @override
  _ChatPageState createState() => _ChatPageState();
}

class _ChatPageState extends State<ChatPage> {
  final RealTimeService realTimeService = RealTimeService();
  List<dynamic> messages = [];

  @override
  void initState() {
    super.initState();
    realTimeService.listenToChat((message) {
      setState(() {
        messages.add(message);
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Chat")),
      body: ListView.builder(
        itemCount: messages.length,
        itemBuilder: (context, index) {
          return ListTile(
            title: Text(messages[index]['message']),
          );
        },
      ),
    );
  }
}
