
        __    __    __    __    __    __    __    __
CLK:   |  |__|  |__|  |__|  |__|  |__|  |__|  |__|  |  (Clock Cycles)
        ________________________________________________________
ALE:   |_____________|                           |_______________
        ________________________________________________________
IO/M:  |_____________|                           |_______________
        _________________________________
A15-A8: 20H                     20H
        ________________________________________________________
AD7-AD0: 05H                     47H
        ________________________________________________________
WR:    |_______________|                          |______________

Explanation:

1. **T1 (Address Setup Time)**:
   - **ALE** goes high to latch the lower address `05H` onto the address bus.
   - **A15-A8** carry the higher-order address bits `20H`.
   - **AD7-AD0** initially carry the lower-order address bits `05H`.

2. **T2 (Data Setup Time)**:
   - **ALE** goes low after latching the address.
   - **IO/M** is low, indicating a memory operation.
   - **AD7-AD0** now carry the data `47H` to be written to memory.
   - **WR** signal goes low to indicate a write operation.

3. **T3 (Write Time)**:
   - **WR** remains low for the duration of the write operation.
   - The data `47H` is written to the memory location `2005H`.

### Summary:

In this timing diagram:
- The address setup occurs during the T1 state, where the higher-order and lower-order address bits are placed on the address bus.
- The data setup occurs during the T2 state, where the data `47H` is placed on the data bus.
- The actual write operation happens during the T3 state, with the `WR` signal low, writing the data to the memory location.

This timing diagram ensures that the correct address and data are available on the buses at the right times for the memory write operation to be successful.
