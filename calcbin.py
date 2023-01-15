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
  binstr = ''
  report(f"Calculating binary value for {number}",show_calculations)
  if (number >= 1<<numbits):
    report("***WARNING YOU NEED TO EXTEND THE numbits OPTION! ***", show_calculations)

  for i in range(numbits):
    report(f"Using current decimal value {number}. This value is currently {'ODD' if number & 1 == 1 else 'EVEN'}, so bit {i} will have the binary value {number & 1}.", show_calculations)
#    bits.append(number & 1)
    # Build up a string version of the binary value
    binstr = str(number & 1) + binstr
    report(f"Dividing the integer value {number} by 2 gives {number//2}", show_calculations)
    number = number // 2
    # look at possibility of breaking out early if we've reached zero
    if (break_early and number == 0):
        break
  #return bits,binstr
  return binstr

# Convert ipv4 dotted string to 32 bit binary string
def convert_ip4_str(ip4_dotted):
    binary_str_values = list(map(lambda _ : calc_binary(int(_)),ip4_dotted.split('.')))
    return ''.join(binary_str_values)


dotted_ip4 = '192.168.1.2'
print(f"{dotted_ip4} == b{convert_ip4_str(dotted_ip4)}")


number = 3
bstr = calc_binary(number,numbits=8, show_calculations = True, break_early = True)
print(f"{number} decimal is equalt to '{bstr}' binary")
