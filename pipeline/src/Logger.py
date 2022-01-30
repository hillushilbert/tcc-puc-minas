class Logger:
    import logging
    import sys

    def __init__(self):
        self.logging.basicConfig(
        level=self.logging.INFO,
        format="%(asctime)s [%(levelname)s] %(message)s",
        handlers=[
            self.logging.FileHandler("info.log"),
            self.logging.StreamHandler(self.sys.stdout)
        ])

    def getLogger(self):
        return self.logging
    
