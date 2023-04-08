import re

#ip4_pattern = "^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$"
ip4_pattern = "(([0-9]{1,3})\.){3}([0-9]{1,3})"

#def binary_string(bitarray):
#    return ''.join(str(bit) for bit in bitarray[::-1])
#    return bitarray

def report(str,show):
    if (show):
        print(str)



# Convert int number to binary string -
# Set key word argument flag 'show_calculations' to show Calculation of Binary bit values
# Set key word argument 'break_early' to True if you want to remove leading zeros.

def calc_binary(number, numbits = 8, break_early = False, show_calculations = False):
 # bits=[]
  orgnumber = number 
  binstr = ''
  report(f"Calculating binary value for octet d{number}",show_calculations)
  if (number >= 1<<numbits):
    report("***WARNING YOU NEED TO EXTEND THE numbits OPTION! ***", show_calculations)

  for i in range(numbits):
    report(f"{number} is {'ODD' if number & 1 == 1 else 'EVEN'} => bit{i} = {number & 1}, {number} // 2 gives {number//2}", show_calculations)

#    bits.append(number & 1)
    # Build up a string version of the binary value
    binstr = str(number & 1) + binstr
    number = number // 2
    # look at possibility of breaking out early if we've reached zero
    if (break_early and number == 0):
        break

  report(f"d{orgnumber} = b{binstr}",show_calculations)
  #return bits,binstr
  return binstr

# Convert ipv4 dotted string to 32 bit binary string
def convert_ip4_str(ip4_dotted,show_calculations=False, break_early = False):
    binary_str_values = list(map(lambda _ : calc_binary(int(_),show_calculations=show_calculations, break_early=break_early),ip4_dotted.split('.')))
    return '.'.join(binary_str_values)


#dotted_ip4 = '172.16.40.60'
#dotted_ip4 = '200.120.192.16'
dotted_ip4 = '192.168.200.10'


print(f"{dotted_ip4} == b{convert_ip4_str(dotted_ip4,show_calculations=True, break_early=False)}")


#number = 149
#bstr = calc_binary(number,numbits=8, show_calculations = True, break_early = False)
#print(f"{number} decimal is equal to '{bstr}' binary")
