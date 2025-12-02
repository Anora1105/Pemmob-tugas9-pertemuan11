class AppExpection implements Exception {
  final _message;
  final _prefix;
  AppExpection([this._message, this._prefix]);
  @override
  String toString() {
    return "$_prefix$_message";
  }
}

class FetchDataException extends AppExpection {
  FetchDataException([String? message])
    : super(message, "Error During Communication: ");
}

class BadRequestException extends AppExpection {
  BadRequestException([message]) : super(message, "invalid Request: ");
}

class UnauthorisedException extends AppExpection {
  UnauthorisedException([message]) : super(message, "Unauthorised: ");
}

class UnprocessableEntityException extends AppExpection {
  UnprocessableEntityException([message])
    : super(message, "Unprocessable Entity: ");
}

class InvalidInputException extends AppExpection {
  InvalidInputException([String? message]) : super(message, "Invalid Input");
}
