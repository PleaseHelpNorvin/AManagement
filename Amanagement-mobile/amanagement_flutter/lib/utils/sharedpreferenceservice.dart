import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert'; 
import '../model/authmodels/user.dart';


class SharedPreferencesService {
  Future<void> saveUserDataToPrefs(String token, UserInfo userInfo, ClientInfo clientInfo, bool isLoggedIn) async {
    final prefs = await SharedPreferences.getInstance();

    // Convert objects to JSON
    String userInfoString =  jsonEncode(userInfo.toJson()); // Use jsonEncode to convert map to string
    String clientInfoString = jsonEncode(clientInfo.toJson());

    // Save to SharedPreferences
    await prefs.setString('Token', token);
    await prefs.setInt('userId', clientInfo.userId);
    await prefs.setString('userInfo', userInfoString);
    await prefs.setString('clientInfo', clientInfoString);
    await prefs.setBool('isLoggedIn', isLoggedIn);

    print("User data saved to SharedPreferences:");
    print("Token: $token");
    print("userId: ${userInfo.id}");
    print("UserInfo JSON: $userInfoString");
    print("ClientInfo JSON: $clientInfoString");
  }

  Future<void> clearUserDataFromPrefs() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('userInfo');
    await prefs.remove('clientInfo');
    await prefs.remove('Token');
    await prefs.remove('userId');
    await prefs.remove('isLoggedIn');
    print("User data cleared from SharedPreferences.");
  }

  Future<Map<String, dynamic>> loadUserDataFromPrefs() async {
    final prefs = await SharedPreferences.getInstance();

    String userInfoString = prefs.getString('userInfo') ?? '';
    String clientInfoString = prefs.getString('clientInfo') ?? '';
    String token = prefs.getString('Token') ?? '';
    int userid = prefs.getInt("userId") ?? 0;

    UserInfo userInfo;
    ClientInfo clientInfo;

    try {
      userInfo = userInfoString.isNotEmpty
          ? UserInfo.fromJson(jsonDecode(userInfoString))
          : UserInfo(
              id: 0,
              username: '',
              email: '',
              createdAt: '',
              updatedAt: '',
              isLoggedIn: false);

      clientInfo = clientInfoString.isNotEmpty
          ? ClientInfo.fromJson(jsonDecode(clientInfoString))
          : ClientInfo(
              id: 0,
              userId: 0,
              name: '',
              middlename: '',
              lastname: '',
              gender: '',
              address: '',
              contactNumber: '',
              createdAt: '',
              updatedAt: '');
    } catch (e) {
      print("Error decoding JSON: $e");
      userInfo = UserInfo(
          id: 0,
          username: '',
          email: '',
          createdAt: '',
          updatedAt: '',
          isLoggedIn: false);
      clientInfo = ClientInfo(
          id: 0,
          userId: 0,
          name: '',
          middlename: '',
          lastname: '',
          gender: '',
          address: '',
          contactNumber: '',
          createdAt: '',
          updatedAt: '');
      String token = prefs.getString('Token') ?? '';
      int userid = prefs.getInt("userId") ?? 0;
    }

    // Debug prints for loaded data
    print("User data loaded from SharedPreferences:");
    print("Token: $token");
    print("User ID: $userid");
    print("UserInfo JSON: $userInfoString");
    print("UserInfo Object: ${userInfo.toJson()}");
    print("ClientInfo JSON: $clientInfoString");
    print("ClientInfo Object: ${clientInfo.toJson()}");

    return {
      'Token': token,
      'userid': userid,
      'userInfo': userInfo,
      'clientInfo': clientInfo,
    };
  }

  Future<Map<String, dynamic>> getUserDataFromPrefs() async {
    final prefs = await SharedPreferences.getInstance();

    String userInfoString = prefs.getString('userInfo') ?? '';
    String clientInfoString = prefs.getString('clientInfo') ?? '';
    String token = prefs.getString('Token') ?? '';
    int userid = prefs.getInt("userId") ?? 0;

    UserInfo userInfo;
    ClientInfo clientInfo;

    try {
      userInfo = userInfoString.isNotEmpty
          ? UserInfo.fromJson(jsonDecode(userInfoString))
          : UserInfo(
              id: 0,
              username: '',
              email: '',
              createdAt: '',
              updatedAt: '',
              isLoggedIn: false);

      clientInfo = clientInfoString.isNotEmpty
          ? ClientInfo.fromJson(jsonDecode(clientInfoString))
          : ClientInfo(
              id: 0,
              userId: 0,
              name: '',
              middlename: '',
              lastname: '',
              gender: '',
              address: '',
              contactNumber: '',
              createdAt: '',
              updatedAt: '');
    } catch (e) {
      print("Error decoding JSON: $e");
      userInfo = UserInfo(
          id: 0,
          username: '',
          email: '',
          createdAt: '',
          updatedAt: '',
          isLoggedIn: false);
      clientInfo = ClientInfo(
          id: 0,
          userId: 0,
          name: '',
          middlename: '',
          lastname: '',
          gender: '',
          address: '',
          contactNumber: '',
          createdAt: '',
          updatedAt: '');
      String token = prefs.getString('Token') ?? '';
      int userid = prefs.getInt("userId") ?? 0;
    }

    // Debug prints for loaded data
    print("User data loaded from SharedPreferences:");
    print("Token: $token");
    print("User ID: $userid");
    print("UserInfo JSON: $userInfoString");
    print("UserInfo Object: ${userInfo.toJson()}");
    print("ClientInfo JSON: $clientInfoString");
    print("ClientInfo Object: ${clientInfo.toJson()}");
    String username = userInfo.username;

    return {
      'token': token,
      'userid': userid,
      'userInfo': userInfo,
      'clientInfo': clientInfo,
      'username' : username
    };
  }
}
