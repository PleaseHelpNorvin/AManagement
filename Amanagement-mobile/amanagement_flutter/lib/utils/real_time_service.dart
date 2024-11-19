import 'package:pusher_client/pusher_client.dart';
class RealTimeService {
  late PusherClient pusher;

  RealTimeService() {
    PusherOptions options = PusherOptions(
      cluster: "your-cluster",
    );

    pusher = PusherClient(
      "your-app-key",
      options,
      enableLogging: true,
    );

    pusher.connect();
  }

  void listenToChat(Function(dynamic) callback) {
    Channel channel = pusher.subscribe("chat");
    channel.bind("MessageSent", (event) {
      callback(event?.data);
    });
  }
}