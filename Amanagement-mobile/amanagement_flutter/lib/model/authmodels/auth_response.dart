import './client_info.dart';
import './user_info.dart';

class AuthResponse {
  final String token;
  final String role;
  final String isLoggedIn; // Changed to String
  final UserInfo userInfo;
  final ClientInfo clientInfo;


  AuthResponse({
    required this.token,
    required this.role,
    required this.isLoggedIn,
    required this.userInfo,
    required this.clientInfo,
  });

  factory AuthResponse.fromJson(Map<String, dynamic> json) {
    return AuthResponse(
      token: json['token'].toString(), // Ensure token is a String
      role: json['role'].toString(), // Ensure role is a String
      isLoggedIn: json['is_logged_in'].toString(), // Ensure isLoggedIn is a String
      userInfo: UserInfo.fromJson(json['user_info']), // Convert to String if needed
      clientInfo: ClientInfo.fromJson(json['client_info']), // Convert to String if needed
    );
   
    // return AuthResponse(
    //   token: json['token'],
    //   role: json['role'],
    //   isLoggedIn: json['is_logged_in'],
    //   userInfo: UserInfo.fromJson(json['user_info']),
    //   clientInfo: ClientInfo.fromJson(json['client_info']),
      
    // );
  }

  
}
