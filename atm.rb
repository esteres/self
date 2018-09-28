class Transaction
  attr_accessor :amount, :timestamp

  def initialize(amount)
    @amount = amount
    @timestamp = Time.now.getutc
  end

  def to_s
    "#{@timestamp} - #{amount} USD"
  end
end

class Account
  def initialize
    @transactions = []
    @bills_amounts = { "100" => 100, "50" => 100, "20" => 100, "5" => 100, "2" => 100, "1" => 100 }
  end

  def bills_ammounts 
    @bills_amounts
  end

  def withdraw(amount)
    add_transaction(amount)
    amount = amount.to_f
    counts = {}
    @bills_amounts.each { |k, v|
      k_int = k.to_i
      if k_int < amount || k_int == amount
        bills_to_return = (amount/k_int).truncate
        counts[k_int] = bills_to_return
        amount = amount % k_int
        @bills_amounts[k] -= bills_to_return  
      end
    } 

    if amount == 0
      total = 0
      counts.each { |k, v| 
        if v != 0 
          current_total = v*k.to_i
          puts "#{v} bills of #{k}= #{current_total}\n"
          total += current_total;
        end
      }
    elsif
      puts "Invalid Amount" 
    end
  end

  def statement
    @transactions.map { |transaction| transaction.to_s }
    
  end

  private
  attr_accessor :transactions

  def add_transaction(amount)
    @transactions << Transaction.new(amount)
  end
end

account = Account.new

loop do
  puts "\nWhat you want to do?\n1- Show amount of bills for each denomination that we have\n2- Withdraw\n3- Daily report\n5- Exit"
  option = gets.chomp
  case option
  when '1'
    puts "Quantity that we have of each denomination:\n\n"
    account.bills_ammounts.each {|key, value| 
      puts "$#{key}  ( #{value} bills)" 
    }
  when '2'
    puts "How many dollars do you want to withdraw?"
    amount = gets.chomp.to_f
    account.withdraw(amount)
  when '3'
    puts "Day's transactions:\n\n"
    puts account.statement.join("\n")
    puts "\nAmount of bills by denomination after day's transactions"
    account.bills_ammounts.each {|key, value| 
      puts "$#{key}  ( #{value} bills)" 
    }
  when '4'
    break
  else
    "Wrong option. Try again."
  end
end
