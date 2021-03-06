module ConcurPar where
import Control.Monad (replicateM)
import Control.Monad.Par
import Text.Printf

spawnProcs :: Par String
spawnProcs = do
    [a, b, c] <- replicateM 3 new
    d <- spawn $ do
        all@[x, y, z] <- sequence [get a, get b, get c]
        return $ printf "%d + %d + %d = %d" x y z (sum all)
    fork $ put a ((2 * 10) :: Int)
    fork $ put b ((2 * 20) :: Int)
    fork $ put c ((30 + 40) :: Int)
    get d

main = putStrLn $ runPar spawnProcs
